<?php

namespace App\Models;

use App\Core\Database;

class Model extends Database
{

    // Table of database
    protected $table;

    // Instance of Database class
    private $db;

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
            if ($key != null && $key != 'db' && $key != 'table') {
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