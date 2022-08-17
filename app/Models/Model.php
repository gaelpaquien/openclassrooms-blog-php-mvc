<?php
namespace App\Models;

use App\Core\Database;

class Model extends Database {

    // Table of the database
    protected $table = null;

    // Instance of the Database class
    private $db;

    public function request(string $sql, array $params = null)
    {
        // Get the instance of Database
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

    public function findAll()
    {
        $query = $this->request('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }
    
}