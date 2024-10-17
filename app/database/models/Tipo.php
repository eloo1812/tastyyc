<?php
namespace app\database\models;

class Tipo extends Base {
    protected $table = 'tipoimg';

    public function getAll() {
        $sql = "SELECT * FROM tipoimg";
        $connection = $this->connection;
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}