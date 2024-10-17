<?php
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\controllers\promo;
use app\controllers\promo2;
use app\controllers\qrcodeSG;
use app\database\models\Usuario;
use app\controllers\Restaurantes;
use app\database\models\Cardapio;
use app\database\models\Restaurante;

class Restaurantes extends Base
{

    private $user;
    private $validate;

    public function __construct()
    {
        $this->user = new Usuario;
        $this->validate = new Validate;
        $this->restaurante = new Restaurante;
        $this->produto = new Cardapio;
    }

    public function index($request, $response, $args) {
        $users = $this->user->find();

        $id = $args['id'];
        $restaurante = $this->restaurante->findBy('idrestaurante', $id);
        $produtos = $this->produto->getById($id);

        $message = Flash::get('message');

        return $this->getTwig()->render($response, $this->setView('site/Restaurantes'), [
            'title' => 'TastyC',
            'users' => $users,
            'message' => $message,
            'restaurante' => $restaurante,
            'produtos' => $produtos
        ]);    
    }
}