<?php
namespace App\Models;

use App\Core\Database;
use PDOStatement;

class CommentsManager extends Database
{

    private Database $db;


    public function countAllInvalid()
    {
        return $this->request("SELECT COUNT(*) as nb_comments_invalid FROM comments WHERE validate = 0")->fetch();
    }

    public function findAllInvalid(int $limit, int $perPage)
    {
        // Query
        $sql = "SELECT 
                    A.id as id,
                    A.author_id as author_id,
                    A.content as content,
                    A.validate as validate,
                    A.validate_by as validate_by,
                    A.article_id as article_id,
                    A.created_at as created_at,
                    B.firstname as authorFirstname,
                    B.lastname as authorLastname,
                    C.slug as articleSlug
                FROM comments as A
                INNER JOIN users as B on A.author_id = B.id
                INNER JOIN articles as C on A.article_id = C.id
                WHERE validate = 0
                ORDER BY created_at ASC
                LIMIT $limit, $perPage";

        // Execute request
        return $this->request($sql)->fetchAll();
    }

    public function findAllValid($id)
    {
        // Query
        $sql = "SELECT 
                    A.id as id,
                    A.author_id as author_id,
                    A.content as content,
                    A.created_at as created_at,
                    B.id as author_id,
                    B.lastname as author_lastname,
                    B.firstname as author_firstname,
                    C.id as admin_id,
                    C.lastname as admin_lastname,
                    C.firstname as admin_firstname
                FROM comments as A
                INNER JOIN users as B on A.author_id = B.id
                INNER JOIN users as C on A.validate_by = C.id
                WHERE article_id = :id AND A.validate = 1 
                ORDER BY created_at DESC";

        // Execute Request
        $results = $this->request($sql, ['id' => $id])->fetchAll();
        
        if (empty($results)) {
            return false;
        }

        // Transforms data
        $data = array();
        foreach ($results as $result) {
            $articlesModel = new CommentsModel;
            $articlesModel->setId($result->id)
                          ->setAuthor_id($result->author_id)
                          ->setContent($result->content)
                          ->setCreated_at($result->created_at);
            $usersModel = new UsersModel;
            $usersModel->setId($result->author_id)
                       ->setLastname($result->author_lastname)
                       ->setFirstname($result->author_firstname);
            array_push($data, $articlesModel, $usersModel);
        }

        // Return data
        return $data;
    }

    public function findAllBy(string $params, string $value)
    {
        // Query 
        $sql = "SELECT * FROM comments WHERE $params = :value";

        // Execute request
        $result = $this->request($sql, ['value' => $value])->fetchAll();

        return $result;
    }

    public function validComment($comment_id, $admin_id) 
    {
        $sql = "UPDATE comments SET validate = 1, validate_by = :admin_id WHERE id = :comment_id";

        return $this->request($sql, ['admin_id' => $admin_id, 'comment_id' => $comment_id]);
    }

    public function create()
    {
        $keys = [];
        $inter = [];
        $values = [];

        // Loop to get parameters and values and add inter("?")
        foreach ($this as $key => $value) {
            if ($value !== null && $key != 'db' && $key != 'table') {
                $keys[] = $key;
                $inter[] = "?";
                $values[] = $value;
            }
        }

        // Transforms array into a string
        $list_keys = implode(', ', $keys);
        $list_inter = implode(', ', $inter);

        // Execute request
        return $this->request('INSERT INTO comments (' . $list_keys . ')VALUES(' . $list_inter . ')', $values);
    }

    public function delete($id)
    {
        return $this->request("DELETE FROM comments WHERE id = ?", [$id]); 
    }

    public function hydrate($data): self
    {
        foreach ($data as $key => $value) {
            // Retrieves setter corresponding to key
            $setter = 'set' . ucfirst($key);
            // Check if setter exists
            if (method_exists($this, $setter)) {
                // Call setter
                $this->$setter($value);
            }
        }
        return $this;
    }

    public function request(string $sql, array $params = null): PDOStatement | false
    {
        // Get instance of database
        $this->db = Database::getInstance();

        // Check if there are any parameters
        if ($params !== null) {
            // Prepared request
            $query = $this->db->prepare($sql);
            $query->execute($params);
            return $query;
        } else {
            // Simple request
            return $this->db->query($sql);
        }
    }

}