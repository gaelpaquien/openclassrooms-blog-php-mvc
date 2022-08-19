<?php
namespace App\Models;

use App\Core\Database;

class Model extends Database
{

    // Table of database
    protected string $table;

    // Instance of Database class
    private Database $db;

    public function findAll()
    {
        $query = $this->request('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    public function findBy(array $params)
    {
        $keys = [];
        $values = [];

        // Loop to get parameters and values
        foreach ($params as $key => $value) {
            $keys[] = "$key = ?";
            $values[] = $value;
        }

        // Transforms array "keys" into a string
        $list_keys = implode(' AND ', $keys);

        // Exec request
        return $this->request('SELECT * FROM ' . $this->table . ' WHERE ' . $list_keys, $values)->fetchAll();
    }

    public function find(int $id)
    {
        return $this->request("SELECT * FROM " . $this->table . " WHERE id = $id")->fetch();
    }

    public function create(Model $model)
    {
        $keys = [];
        $inter = [];
        $values = [];

        // Loop to get parameters and values
        foreach ($model as $key => $value) {
            if ($value !== null && $key != 'db' && $key != 'table') {
                $keys[] = $key;
                $inter[] = "?";
                $values[] = $value;
            }
        }

        // Transforms array "keys" into a string
        $list_keys = implode(', ', $keys);
        $list_inter = implode(', ', $inter);

        // Execute request
        return $this->request('INSERT INTO ' . $this->table . ' (' . $list_keys . ')VALUES(' . $list_inter . ')', $values);
    }

    public function update(int $id, Model $model)
    {
        $keys = [];
        $values = [];

        // Loop to get parameters and values
        foreach ($model as $key => $value) {
            if ($value !== null && $key != 'db' && $key != 'table') {
                $keys[] = "$key = ?";
                $values[] = $value;
            }
        }
        // Retrieves id from the values array
        $values[] = $id;

        // Transforms array "keys" into a string
        $list_keys = implode(', ', $keys);

        // Execute request
        return $this->request('UPDATE ' . $this->table . ' SET ' . $list_keys . ' WHERE id = ?', $values);
    }

    public function delete(int $id)
    {
        return $this->request("DELETE FROM " . $this->table . " WHERE id = ?", [$id]);
    }

    public function hydrate(array $data)
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

    public function request(string $sql, array $params = null)
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
