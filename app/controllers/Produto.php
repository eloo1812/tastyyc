<?php 
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Usuario;
use app\database\models\Cardapio;

class Produto extends Base {
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

        $message = Flash::get('message');

        $idProduto = $args['id'];

        $produto = $this->produto->getByIdWithRestaurant($idProduto);
        $nomeProduto = $produto['produto_nome'];

        return $this->getTwig()->render($response, $this->setView('site/produto'), [
            'title' => $nomeProduto,
            'users' => $users,
            'produto' => $produto
        ]);    
    }
}