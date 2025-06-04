<?php
namespace App\Models;

use App\Core\Database;
use PDOStatement;

class GlobalManager extends Database
{
    public function countAll(string $table): mixed
    {
        // Execute query and return result
        return $this->request("SELECT COUNT(*) as nb_$table FROM $table")->fetch();
    }

    public function checkExists(string $table, string $params, string $value): bool
    {
        // Query
        $sql = "SELECT * FROM $table WHERE $params = :value";
        
        // Execute query
        $result = $this->request($sql, ['value' => $value])->fetch();

        // Check and return result
        if ($result) {
            return true;
        }
        return false;
        
    }

    public function findAllBy(string $table, string $params, string $value): mixed
    {
        // Query 
        $sql = "SELECT * FROM $table WHERE $params = :value";

        // Execute query
        $result = $this->request($sql, ['value' => $value])->fetchAll();

        // Return result
        return $result;
    }

    public function create(string $table): PDOStatement | false
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

        // Execute query and return result
        return $this->request('INSERT INTO ' . $table . ' (' . $list_keys . ')VALUES(' . $list_inter . ')', $values);
    }

    public function update(string $table): PDOStatement | false
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
        // Retrieves id from values array
        $values[] = $this->id;

        // Transforms array into a string
        $list_keys = implode(', ', $keys);

        // Execute query and return result
        return $this->request('UPDATE ' . $table .  ' SET ' . $list_keys . ' WHERE id = ?', $values);
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

        // Return $this
        return $this;
    }

    public function delete(string $table, int $id): PDOStatement | false 
    {
        // Execute query and return result
        return $this->request("DELETE FROM $table WHERE id = :id", ['id' => $id]);
    }

    public function request(string $sql, array $params = null): PDOStatement | false
    {
        // Get instance of database
        $this->db = Database::getInstance();

        // Check if there are any parameters
        if ($params !== null) {
            // Prepared query
            $query = $this->db->prepare($sql);
            $query->execute($params);
            return $query;
        } else {
            // Simple query
            return $this->db->query($sql);
        }
    }

}