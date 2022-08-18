<?php

namespace App\Core;

use PDO;
use PDOException;

class Database extends PDO
{

    // Unique instance of class
    private static $instance;

    // Database information
    private const DBHOST = '127.0.0.1';
    private const DBNAME = 'blog';
    private const DBUSER = 'root';
    private const DBPASS = 'root';

    private function __construct()
    {
        // DNS connection
        $_dsn = 'mysql:dbname=' . self::DBNAME . ';host=' . self::DBHOST;

        // Call the constructor of PDO class
        try {
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);
            // PDO Attribute
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance(): PDO
    {
        // Create an instance if there is none and return the current instance
        if (self::$instance === null) {
            self::$instance = new Database;
        }
        return self::$instance;
    }
}
