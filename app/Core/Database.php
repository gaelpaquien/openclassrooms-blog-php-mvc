<?php
namespace App\Core;

use App\Helpers\Superglobals;
use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database extends PDO
{

    // Unique instance of class
    private static $instance;

    private function __construct()
    {
        // Load Dotenv (.env -> $_ENV)
        $dotenv = Dotenv::createImmutable(ROOT);
        $dotenv->load();

        // Load Superglobals ($_ENV)
        $superglobals = new Superglobals;

        // Data Source Name
        $dsn = 'mysql:dbname=' . $superglobals->get_ENV()['DB_NAME'] . ';host=' . $superglobals->get_ENV()['DB_HOST'];

        // Call the constructor of PDO class
        try {
            parent::__construct($dsn, $superglobals->get_ENV()['DB_USER'], $superglobals->get_ENV()['DB_PASSWORD']);
            // PDO attribute
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $e->getMessage();
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
