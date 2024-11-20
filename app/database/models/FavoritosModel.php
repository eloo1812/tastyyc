<?php 
namespace app\database\models;

use PDO;
use app\traits\Connection;

class FavoritosModel extends Base {
    use Connection;
    protected $table = 'usuarios_favoritos';

    public function getAllById($id) {
        $sql = "SELECT DISTINCT
                    uf.idfavoritos, 
                    uf.usuarios_id, 
                    uf.idrefeicao,
                    p.nome AS produto_nome, 
                    p.descricao, 
                    p.valor, 
                    p.localizacao,
                    r.nome AS restaurante_nome,
                    r.endereco
                FROM 
                    usuarios_favoritos uf
                JOIN 
                    produto p ON uf.idrefeicao = p.idrefeicao
                JOIN 
                    restaurante r ON p.idrestaurante = r.idrestaurante
                WHERE 
                    uf.usuarios_id = :usuarios_id;
                ";
    
        $connection = $this->connection;
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':usuarios_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}