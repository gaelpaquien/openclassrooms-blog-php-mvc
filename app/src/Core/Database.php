<?php
namespace App\Core;

use PDO;
use PDOException;

class Database extends PDO
{
    // Unique instance of class
    private static $instance;

    private function __construct()
    {
        // Database informations (Data Source Name) - utilise directement $_ENV
        $dsn = 'mysql:dbname=' . $_ENV['MYSQL_DATABASE'] . ';host=' . $_ENV['DATABASE_HOST'] . ';charset=utf8mb4';

        // Call the constructor of PDO class
        try {
            parent::__construct($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
            // PDO attributes
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        // Create an instance if there is none and return the current instance
        if (self::$instance === null) {
            self::$instance = new Database;
        }
        return self::$instance;
    }
}