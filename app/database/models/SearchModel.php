<?php
namespace app\database\models;

use PDO;
use app\database\models\Base;

class SearchModel extends Base {

    public function getAll($query) {
        // Sanitizar e validar a consulta
        $query = htmlspecialchars(strip_tags($query));

        $sql = "
        SELECT 
            p.nome AS produto_nome,
            r.nome AS restaurante_nome
        FROM 
            produto p
        LEFT JOIN 
            restaurante r ON p.idrestaurante = r.idrestaurante
        WHERE 
            p.nome LIKE :query 
            OR r.nome LIKE :query
        UNION
        SELECT 
            NULL AS produto_nome,
            r.nome AS restaurante_nome
        FROM 
            restaurante r
        WHERE 
            r.nome LIKE :query
    ";

        $connection = $this->connection;
        $stmt = $connection->prepare($sql);
        $stmt->execute(['query' => "%$query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}