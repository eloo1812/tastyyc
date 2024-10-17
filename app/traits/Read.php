<?php
namespace app\traits;

use PDO;
use PDOException;
use app\traits\Connection as Connect;

trait Read
{
    public function find($fetchAll = true)
    {
        try {
            $query = $this->connection->query("SELECT * FROM {$this->table}");
            return $fetchAll ? $query->fetchAll() : $query->fetch();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function findBy($field, $value, $fetchAll = false)
    {
        try {
            $prepared = $this->connection->prepare("SELECT * FROM {$this->table} WHERE {$field} = :{$field}");
            $prepared->bindValue(":{$field}", $value);
            $prepared->execute();
            return $fetchAll ? $prepared->fetchAll() : $prepared->fetch();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function findByEmail($email) {
        try {
            $stmt = $this->connection->prepare("
            SELECT 
                usuarios.id, 
                usuarios.nome, 
                usuarios.email, 
                usuarios.senha, 
                MAX(CASE WHEN administrador.idadministrador IS NOT NULL THEN 1 ELSE 0 END) AS admin
            FROM usuarios
            LEFT JOIN administrador ON administrador.idadministrador = usuarios.id
            WHERE usuarios.email = :email
            GROUP BY usuarios.id, usuarios.nome, usuarios.email, usuarios.senha
        ");

        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_OBJ);
        
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}