<?php 
namespace app\database\models;

use app\traits\Connection;

class Comentario extends Base {
    use Connection;
    protected $table = 'comentario_restaurante';
    
    public function getAll() {
        $sql = "SELECT 
                    comentario_restaurante.*, 
                    restaurante.nome AS nome_restaurante, 
                    usuarios.nome AS nome_usuario,
                    usuarios.icone AS icone_usuario
                FROM 
                    comentario_restaurante
                JOIN 
                    restaurante ON comentario_restaurante.restaurante_idrestaurante = restaurante.idrestaurante
                JOIN 
                    usuarios ON comentario_restaurante.usuarios_id = usuarios.id;
";
        $connection = $this->connection;
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}