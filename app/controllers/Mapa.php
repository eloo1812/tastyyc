<?php 
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Usuario;
use app\database\models\Restaurante;

class Mapa extends Base {
    public function __construct()
    {
        $this->user = new Usuario;
        $this->validate = new Validate;
        $this->restaurante = new Restaurante;
    }

    public function index($request, $response, $args) {
        $id = $args['id'];
        
        $messages = Flash::getAll();

        $restaurante = $this->restaurante->findBy('idrestaurante', $id);

        return $this->getTwig()->render($response, $this->setView('site/mapa'), [
            'title' => 'TastyC',
            'messages' => $messages,
            'restaurante' => $restaurante
        ]);    
    }
}