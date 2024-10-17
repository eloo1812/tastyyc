<?php
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Usuario;
use app\database\models\Restaurante;

class CadastroRes extends Base
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

        return $this->getTwig()->render($response, $this->setView('site/CadastroRes'), [
            'title' => 'TastyC',
            'users' => $users,
            'message' => $message
        ]);    
    }

    public function cadastrar($request, $response, $args) {
        $nomeRes = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $nomeProp = filter_input(INPUT_POST, 'nomeProprietario', FILTER_SANITIZE_STRING);
        $caminho = filter_input(INPUT_POST, 'caminho', FILTER_SANITIZE_STRING);

        $this->validate->required(['nome', 'endereco', 'email', 'nomeProprietario']);
        $errors = $this->validate->getErrors();

        if ($errors) {
            Flash::flashes($errors);
            return \app\helpers\redirect($response, '/CadastroRes');
        }

        // Criar um restaurante novo
        
        $created = $this->restaurante->create([
            'nome' => $nomeRes,
            'endereco' => $endereco,
            'email' => $email,
            'nome_proprietario' => $nomeProp,
            'caminho' => $caminho
        ]);

        if ($created) {
            Flash::set('message', 'Restaurante registrado com sucesso');
            return \app\helpers\redirect($response, '/home');
        }

        Flash::set('message', 'Ocorreu um erro ao criar o restaurante');
        return \app\helpers\redirect($response, '/CadastroRes');
    }
}