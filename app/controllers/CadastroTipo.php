<?php 
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Tipo;
use app\database\models\Usuario;

class CadastroTipo extends Base {
    private $user;
    private $validate;

    public function __construct()
    {
        $this->user = new Usuario;
        $this->validate = new Validate;
        $this->tipo = new Tipo;
    }

    public function index($request, $response) {
        $users = $this->user->find();

        $message = Flash::get('message');

        return $this->getTwig()->render($response, $this->setView('site/CadastroTipo'), [
            'title' => 'TastyC',
            'users' => $users,
            'message' => $message
        ]);    
    }

    public function cadastrar($request, $response, $args) {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $caminho = filter_input(INPUT_POST, 'caminho', FILTER_SANITIZE_STRING);


        $this->validate->required(['nome', 'caminho']);
        $errors = $this->validate->getErrors();

        if ($errors) {
            Flash::flashes($errors);
            return \app\helpers\redirect($response, '/CadastroTipo');
        }

        // Criar um restaurante novo
        
        $created = $this->tipo->create([
            'nome' => $nome,
            'caminho' => $caminho
        ]);

        if ($created) {
            Flash::set('message', 'Tipo registrado com sucesso');
            return \app\helpers\redirect($response, '/CadastroTipo');
        }

        Flash::set('message', 'Ocorreu um erro ao criar o tipo');
        return \app\helpers\redirect($response, '/CadastroTipo');
    }
}