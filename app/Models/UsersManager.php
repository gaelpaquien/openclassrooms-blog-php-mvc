<?php
namespace App\Models;

use App\Core\Database;
use PDOStatement;

class UsersManager extends Database
{

    public function findBy(string $params, string $value) : UsersModel | null
    {
        $user = null;

        // Query 
        $sql = "SELECT * FROM users WHERE $params = :value";

        // Execute request
        $result = $this->request($sql, ['value' => $value])->fetch();

        // Check result and create UsersModel
        if ($result) {
            $user = new UsersModel;
            $user->setId($result->id)
                 ->setEmail($result->email)
                 ->setPassword($result->password)
                 ->setFirstname($result->firstname)
                 ->setLastname($result->lastname)
                 ->setAdmin($result->admin)
                 ->setCreated_at($result->created_at);
        }

        // Return $user
        return $user;
    }

    public function find(int $id): PDOStatement | false
    {
        // Query 
        $sql = "SELECT * FROM users WHERE id = :id";

        // Execute request
        return $this->request($sql, ['id' => $id])->fetch();
    }

    public function findAllAdmin()
    {
        return $this->request("SELECT * FROM users WHERE admin = 1")->fetchAll();
    }

    public function checkExists(string $params, string $value): bool
    {
        // Query
        $sql = "SELECT * FROM users WHERE $params = :value";

        // Execute request
        $result = $this->request($sql, ['value' => $value])->fetch();

        // Check result and return bool
        if ($result) {
            return true;
        } else {
            return false;
        }
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
        return $this->request('INSERT INTO users (' . $list_keys . ')VALUES(' . $list_inter . ')', $values);
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