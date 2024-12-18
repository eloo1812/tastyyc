<?php
namespace app\traits;

use PDOException;
use app\database\models\Connection;


trait Delete
{
    
    public function delete($field, $value)
    {
        try {
            $prepare = $this->connection->prepare("DELETE FROM {$this->table} WHERE {$field} = :{$field}");
            $prepare->bindValue($field, $value);
            return $prepare->execute();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}