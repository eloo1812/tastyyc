<?php 
namespace app\database\models;

use PDO;
use app\traits\Connection;

class Cardapio extends Base {
    use Connection;
    protected $table = 'produto';

    public function getAll() {
        $sql = "SELECT 
                    p.idrefeicao, 
                    p.nome AS produto_nome, 
                    p.descricao, 
                    p.valor AS produto_valor,
                    r.nome AS restaurante_nome,
                    t.nome AS tipoimg_nome,
                    t.caminho AS tipoimg_caminho
                FROM 
                    produto p
                JOIN 
                    restaurante r ON p.idrestaurante = r.idrestaurante
                LEFT JOIN 
                    tipoimg t ON p.tipoimg = t.id;

        ";
        
        $connection = $this->connection;
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getById($id) {
        $sql = "SELECT 
                    p.*, 
                    t.nome AS tipoimg_nome,
                    t.caminho AS tipoimg_caminho
                FROM 
                    produto p
                LEFT JOIN 
                    tipoimg t ON p.tipoimg = t.id
                WHERE 
                    p.idrestaurante = :idrestaurante;
                ";
    
        $connection = $this->connection;
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':idrestaurante', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByIdWithRestaurant($id) {
        $sql = "SELECT 
                    p.idrefeicao, 
                    p.nome AS produto_nome, 
                    p.descricao, 
                    p.valor AS produto_valor,
                    r.nome AS restaurante_nome,
                    r.endereco AS restaurante_endereco,
                    t.nome AS tipoimg_nome,
                    t.caminho AS tipoimg_caminho
                FROM 
                    produto p
                JOIN 
                    restaurante r ON p.idrestaurante = r.idrestaurante
                LEFT JOIN 
                    tipoimg t ON p.tipoimg = t.id
                WHERE 
                    p.idrefeicao = :idrefeicao;
";
    
        $connection = $this->connection;
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':idrefeicao', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Use fetch() for a single record
    }

    public function getPrincipais() {
        $sql = "SELECT 
                    p.*, 
                    t.nome AS tipoimg_nome,
                    t.caminho AS tipoimg_caminho
                FROM 
                    produto p
                LEFT JOIN 
                    tipoimg t ON p.tipoimg = t.id
                ORDER BY 
                    p.nome ASC 
                LIMIT 8;
";
        $connection = $this->connection;
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}