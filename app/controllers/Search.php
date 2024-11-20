<?php
namespace app\controllers;

use app\traits\Connection;
use app\database\models\SearchModel;

class Search extends Base {

    private $searchModel;

    public function __construct()
    {
        $this->searchModel = new SearchModel;
    }

    public function index($request, $response, $args) {
        // Filtra e obtém o parâmetro de busca
        $query = filter_input(INPUT_GET, 'search-box', FILTER_SANITIZE_STRING) ?? '';

        // Instanciar o modelo de busca e obter resultados
        $results = $this->searchModel->getAll($query);
    
        return $this->getTwig()->render($response, $this->setView('site/Resposta'), [
            'query' => htmlspecialchars($query), // Sanitiza o parâmetro para exibição
            'results' => $results,
            'title' => 'TastyC'
        ]);
    }
    
}