<?php
namespace App\Models;

use App\Core\Database;
use PDOStatement;

class UsersManager extends Database
{

    public function findBy(string $params, string $value) 
    {
        $sql = "SELECT * FROM users WHERE $params = :value";
        $result = $this->request($sql, ['value' => $value])->fetch();

        $user = new UsersModel;
        $user->setId($result->id)
             ->setEmail($result->email)
             ->setPassword($result->password)
             ->setFirstname($result->firstname)
             ->setLastname($result->lastname)
             ->setAdmin($result->admin)
             ->setCreated_at($result->created_at);

        return $user;
    }

    public function find(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        return $this->request($sql, ['id' => $id])->fetch();
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