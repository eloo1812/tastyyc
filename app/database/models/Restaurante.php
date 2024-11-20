<?php 
namespace app\database\models;

use app\traits\Connection;

class Restaurante extends Base {
    use Connection;
    protected $table = 'restaurante';

    public function getAll() {
        $sql = "SELECT * FROM restaurante";
        $connection = $this->connection;
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    
}