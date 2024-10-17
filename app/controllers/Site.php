<?php
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Usuario;
use app\database\models\Cardapio;

class Site extends Base 
{
    private $user;
    private $validate;

    public function __construct()
    {
        $this->user = new Usuario;
        $this->validate = new Validate;
        $this->produto = new Cardapio;
    }

    public function index($request, $response, $args) {
        $users = $this->user->find();

        $id = $_SESSION['user_logged_data']['id'];
        $user = $this->user->findBy('id', $id);

        $message = Flash::get('message');

        $produtos = $this->produto->getPrincipais();

        $userLoggedData = $_SESSION['user_logged_data'] ?? null;

        $idBeto = 3;
        $betos = $this->produto->getById($idBeto);

        return $this->getTwig()->render($response, $this->setView('site/main'), [
            'title' => 'TastyC',
            'users' => $users,
            'message' => $message,
            'user' => $user,
            'user_logged_data' => $userLoggedData,
            'produtos' => $produtos,
            'betos' => $betos
        ]);    
    }
}