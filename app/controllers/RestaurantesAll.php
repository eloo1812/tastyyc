<?php
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\controllers\promo;
use app\controllers\promo2;
use app\controllers\qrcodeSG;
use app\controllers\qrcodeGRE;
use app\database\models\Usuario;
use app\controllers\RestaurantesAll;
use app\database\models\Restaurante;

class RestaurantesAll extends Base
{

    private $user;
    private $validate;

    public function __construct()
    {
        $this->user = new Usuario;
        $this->validate = new Validate;
        $this->restaurante = new Restaurante;
    }

    public function index($request, $response) {
        $users = $this->user->find();

        $message = Flash::get('message');

        $restaurantes = $this->restaurante->getAll();

        return $this->getTwig()->render($response, $this->setView('site/RestaurantesAll'), [
            'title' => 'TastyC',
            'users' => $users,
            'message' => $message,
            'restaurantes' => $restaurantes
        ]);    
    }
}