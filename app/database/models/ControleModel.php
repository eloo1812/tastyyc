<?php
namespace app\database\models;

use PDO;
use app\traits\Connection;

class ControleModel extends Base {
    use Connection;
    protected $table = 'gasto';

    

    
    public function getAllById($id) {
        $sql = "SELECT 
                    g.idgasto, 
                    g.data, 
                    g.valor AS gasto_valor,
                    u.nome AS usuario_nome, 
                    p.nome AS produto_nome, 
                    p.descricao, 
                    p.valor AS produto_valor,
                    r.nome AS restaurante_nome, 
                    r.endereco AS restaurante_endereco,
                    t.nome AS tipoimg_nome,
                    t.caminho AS tipoimg_caminho
                FROM 
                    gasto g
                JOIN 
                    usuarios u ON g.usuarios_id = u.id
                JOIN 
                    produto p ON g.refeicao_idrefeicao = p.idrefeicao
                JOIN 
                    restaurante r ON p.idrestaurante = r.idrestaurante
                LEFT JOIN 
                    tipoimg t ON p.tipoimg = t.id
                WHERE 
                    g.usuarios_id = :usuarios_id";
                
        
        $connection = $this->connection;
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':usuarios_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


    // calcular
    public function getProdutoById($id) {
        $sql = "SELECT valor FROM produto WHERE idrefeicao = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function getTotalDia($id) {
        $sql = "SELECT 
                    SUM(valor) AS total_dia
                FROM 
                    gasto
                WHERE 
                    usuarios_id = :usuarios_id
                    AND DATE(data) = CURDATE()";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':usuarios_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() ?: 0;
    }
    
    public function getTotalSemana($id) {
        $sql = "SELECT 
                    SUM(valor) AS total_semana
                FROM 
                    gasto
                WHERE 
                    usuarios_id = :usuarios_id
                    AND data >= CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY
                    AND data < CURDATE() - INTERVAL WEEKDAY(CURDATE()) - 6 DAY";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':usuarios_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() ?: 0;
    }
    
    public function getTotalMes($id) {
        $sql = "SELECT 
                    SUM(valor) AS total_mes
                FROM 
                    gasto
                WHERE 
                    usuarios_id = :usuarios_id
                    AND YEAR(data) = YEAR(CURDATE())
                    AND MONTH(data) = MONTH(CURDATE())";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':usuarios_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() ?: 0;
    }
    
    public function getTotalAno($id) {
        $sql = "SELECT 
                    SUM(valor) AS total_ano
                FROM 
                    gasto
                WHERE 
                    usuarios_id = :usuarios_id
                    AND YEAR(data) = YEAR(CURDATE())";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':usuarios_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() ?: 0;
    }
}