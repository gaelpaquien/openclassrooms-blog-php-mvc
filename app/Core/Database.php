<?php
namespace App\Core;

use App\Helpers\Superglobal;
use PDO;
use PDOException;

class Database extends PDO
{

    // Unique instance of class
    private static $instance;

    private function __construct()
    {
        // Load superglobal ($_ENV)
        $superglobal = new Superglobal;

    // Database informations (Data Source Name)
    $dsn = 'mysql:dbname=' . $superglobal->get_ENV()['MYSQL_DATABASE'] . ';host=' . $superglobal->get_ENV()['DATABASE_HOST'] . ';charset=utf8mb4';

    // Call the constructor of PDO class
    try {
        parent::__construct($dsn, $superglobal->get_ENV()['MYSQL_USER'], $superglobal->get_ENV()['MYSQL_PASSWORD']);
        // PDO attributes
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
