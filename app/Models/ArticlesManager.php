<?php
namespace App\Models;

use App\Core\Database;
use PDOStatement;

class ArticlesManager extends Database
{

    private Database $db;

    public function findAll(int $limit = 0): array
    {
        // Default query
        $sql = 'SELECT * FROM article ORDER BY updated_at DESC, created_at DESC';
        // Add a limit if it is defined
        if ($limit !== 0) {
            $sql .= ' LIMIT ' . $limit;
        }

        // Execute request
        $query = $this->request($sql);
        $items = $query->fetchAll();

        // Transforms and returns data
        $data = array();
        foreach ($items as $item) {
            $model = new ArticlesModel;
            $model->setId($item->id)
                  ->setTitle($item->title)
                  ->setSlug($item->slug)
                  ->setContent($item->content)
                  ->setCaption($item->caption)
                  ->setAuthor_id($item->author_id)
                  ->setCreated_at($item->created_at)
                  ->setUpdated_at($item->updated_at)
                  ->setPicture($item->picture);

            array_push($data, $model);
        }
        return $data;
    }

    public function find(int $id): array
    { 
        // Query
        $sql = "SELECT 
                    A.id as id,
                    A.title as title,
                    A.slug as slug,
                    A.content as content,
                    A.caption as caption,
                    A.created_at as created_at,
                    A.updated_at as updated_at,
                    A.author_id as author_id,
                    A.picture as picture,
                    B.lastname as author_lastname,
                    B.firstname as author_firstname
                FROM article as A 
                INNER JOIN user as B ON A.author_id = B.id
                WHERE A.id = :id";

        // Execute request
        $result = $this->request($sql, ['id' => $id])->fetch();

        // Transforms and returns data
        $data = array();
        
        $articlesModel = new ArticlesModel;
        $articlesModel->setId($result->id)
                      ->setTitle($result->title)
                      ->setSlug($result->slug)
                      ->setContent($result->content)
                      ->setCaption($result->caption)
                      ->setAuthor_id($result->author_id)
                      ->setCreated_at($result->created_at)
                      ->setUpdated_at($result->updated_at)
                      ->setPicture($result->picture);

        $usersModel = new UsersModel;
        $usersModel->setId($result->author_id)
                   ->setLastname($result->author_lastname)
                   ->setFirstname($result->author_firstname);

        array_push($data, $articlesModel, $usersModel);
        return $data;
    }

    public function create(): PDOStatement | false
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
        return $this->request('INSERT INTO article (' . $list_keys . ')VALUES(' . $list_inter . ')', $values);
    }

    public function update(): PDOStatement | false
    {
        $keys = [];
        $values = [];

        // Loop to get parameters and values
        foreach ($this as $key => $value) {
            if ($value !== null && $key != 'db' && $key != 'table') {
                $keys[] = "$key = ?";
                $values[] = $value;
            }
        }
        // Retrieves id from the values array
        $values[] = $this->id;

        // Transforms array into a string
        $list_keys = implode(', ', $keys);

        // Execute request
        return $this->request('UPDATE article SET ' . $list_keys . ' WHERE id = ?', $values);
    }

    public function delete(int $id) 
    {
        return $this->request("DELETE FROM article WHERE id = ?", [$id]);
    }

    public function hydrate($data): self
    {
        foreach ($data as $key => $value) {
            // Retrieves the setter corresponding to the key
            $setter = 'set' . ucfirst($key);
            // Check if the setter exists
            if (method_exists($this, $setter)) {
                // Call the setter
                $this->$setter($value);
            }
        }
        return $this;
    }

    public function request(string $sql, array $params = null): PDOStatement|false
    {
        // Get instance of Database
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