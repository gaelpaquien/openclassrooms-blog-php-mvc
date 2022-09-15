<?php
namespace App\Models;

use App\Core\Database;
use PDOStatement;

class CommentsManager extends Database
{

    private Database $db;

    public function findValidateComments($id)
    {
        // Query
        $sql = "SELECT 
                    A.id as id,
                    A.author_id as author_id,
                    A.content as content,
                    A.created_at as created_at,
                    B.lastname as author_lastname,
                    B.firstname as author_firstname,
                    C.lastname as admin_lastname,
                    C.firstname as admin_firstname
                FROM comments as A
                INNER JOIN users as B on A.author_id = B.id
                INNER JOIN users as C on A.validate_by = C.id
                WHERE article_id = :id AND A.validate = 1 
                ORDER BY created_at DESC";

        // Execute Request
        $result = $this->request($sql, ['id' => $id]);
        $data = $result->fetchAll();
        
        if (empty($data)) {
            return false;
        }

        return $data;
    }

    public function create()
    {

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