<?php
namespace App\Core;

use \PDO;
use \Exception;

class Database {

    public static function getPDO(): PDO
    {
        require(dirname(__DIR__) . '../../config/db.php');
        $host = getenv("DB_HOST");
        $database = getenv("DB_DATABASE");
        $username = getenv("DB_USERNAME");
        $password = getenv("DB_PASSWORD");
        
        try {
            return new PDO("mysql:host=$host;dbname=$database", "$username", "$password", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]); 
        } catch(Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }

}
