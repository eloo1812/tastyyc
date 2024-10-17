<?php
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Tipo;
use app\database\models\Usuario;
use app\database\models\Cardapio;
use app\database\models\Restaurante;

class CadastroCar extends Base
{

    private $user;
    private $validate;

    public function __construct()
    {
        $this->user = new Usuario;
        $this->validate = new Validate;
        $this->restaurante = new Restaurante;
        $this->cardapio = new Cardapio;
        $this->tipo = new Tipo;
    }

    public function index($request, $response) {
        $users = $this->user->find();

        $message = Flash::get('message');
        $restaurantes = $this->restaurante->getAll();
        $tipos = $this->tipo->getAll();

        return $this->getTwig()->render($response, $this->setView('site/CadastroCardapio'), [
            'title' => 'TastyC',
            'users' => $users,
            'message' => $message,
            'restaurantes' => $restaurantes,
            'tipos' => $tipos
        ]);    
    }

    public function cadastrar($request, $response, $args) {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);

        $preco = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $preco = str_replace(',', '.', $preco);

        // Converter para float
        $preco = (float)$preco;
    
        // Formatando o valor com duas casas decimais
        $preco = number_format($preco, 2, '.', '');

        $localizacao = filter_input(INPUT_POST, 'localizacao', FILTER_SANITIZE_STRING);
        $idrestaurante = filter_input(INPUT_POST, 'restaurante', FILTER_SANITIZE_NUMBER_INT);
        $idTipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT);

        $this->validate->required(['nome', 'descricao', 'valor', 'localizacao', 'restaurante', 'tipo']);
        $errors = $this->validate->getErrors();

        if ($errors) {
            Flash::flashes($errors);
            return \app\helpers\redirect($response, '/CadastroCardapio');
        }

        $created = $this->cardapio->create([
            'nome' => $nome,
            'descricao' => $descricao,
            'valor' => $preco,
            'localizacao' => $localizacao,
            'idrestaurante' => $idrestaurante,
            'tipoimg' => $idTipo
        ]);

        if ($created) {
            Flash::set('message', 'Produto registrado com sucesso');
            return \app\helpers\redirect($response, '/CadastroCardapio');
        }

        Flash::set('message', 'Ocorreu um erro ao criar o produto');
        return \app\helpers\redirect($response, '/CadastroCardapio');
    }
}