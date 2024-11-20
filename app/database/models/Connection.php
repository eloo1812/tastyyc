<?php
namespace app\database\models;
use PDO;
use PDOException;

class Connection extends Base
{
    private static $pdo;

    
    public static function connection()
    {
        if (static::$pdo) {
            return static::$pdo;
        } 

        try {

            
                static::$pdo = new PDO('mysql:host=mysql.infocimol.com.br;dbname=infocimol18', 'infocimol18', 'tastyc1234', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);

            return static::$pdo;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}
