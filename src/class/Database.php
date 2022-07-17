<?php
namespace App;

use \PDO;
use \Exception;

class Database {

    public static function getPDO(): PDO
    {
        try {
            return new PDO('mysql:host=127.0.0.1;dbname=dbtest', 'root', 'password', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]); 
        } catch(Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }

}