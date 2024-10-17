<?php
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\controllers\promo;
use app\controllers\promo2;
use app\controllers\qrcodeSG;
use app\controllers\qrcodeGRE;
use app\controllers\comentarios;
use app\database\models\Usuario;
use app\database\models\Comentario;
use app\database\models\Restaurante;

class comentarios extends Base
{

    private $user;
    private $validate;

    public function __construct()
    {
        $this->user = new Usuario;
        $this->validate = new Validate;
        $this->comentario = new Comentario;
        $this->restaurante = new Restaurante;

    }

    public function index($request, $response) {
        $users = $this->user->find();

        $messages = Flash::getAll();

        $restaurantes = $this->restaurante->getAll();
        $comentarios = $this->comentario->getAll();


        return $this->getTwig()->render($response, $this->setView('site/comentarios'), [
            'title' => 'TastyC',
            'users' => $users,
            'messages' => $messages,
            'restaurantes' => $restaurantes,
            'comentarios' => $comentarios
        ]);    
    }

    public function store($request, $response, $args)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $restauranteId = filter_input(INPUT_POST, 'restaurante', FILTER_SANITIZE_NUMBER_INT);
        $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_INT);
        $conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_SANITIZE_STRING);
        $dataAtual = date('Y-m-d H:i:s');

        $idUser = $_SESSION['user_logged_data']['id'];

        $this->validate->required(['preco', 'conteudo']);
        $errors = $this->validate->getErrors();

        if ($errors) {
            Flash::flashes($errors);
            return \app\helpers\redirect($response, '/home');
        }

        $created = $this->comentario->create(['restaurante_idrestaurante' => $restauranteId, 'preco' => $preco, 'data' => $dataAtual, 'conteudo' => $conteudo, 'usuarios_id' => $idUser]);
        
        if ($created)
        {
            Flash::set('message', 'Comentado com sucesso');

            return \app\helpers\redirect($response, '/comentarios'); 
        }


        Flash::set('message', 'Ocorreu um erro ao comentar');
        return \app\helpers\redirect($response, '/comentarios');

    }
}