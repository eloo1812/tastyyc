<?php
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Usuario;
use app\database\models\ControleModel;


class Controle extends Base {
    public function __construct()
    {
        $this->user = new Usuario;
        $this->validate = new Validate;
        $this->comprados = new ControleModel;
        
    }

    public function index($request, $response, $args) {
        $id = $args['idUser'];
        $user = $this->user->findBy('id', $id);
        $idUser = $_SESSION['user_logged_data']['id'];

        $totalSemana = $this->comprados->getTotalSemana($id);
        $totalMes = $this->comprados->getTotalMes($id);
        $totalAno = $this->comprados->getTotalAno($id);
        $totalDia = $this->comprados->getTotalDia($id); 
        

        $messages = Flash::getAll();

        

        $comprados = $this->comprados->getAllById($idUser);

        return $this->getTwig()->render($response, $this->setView('site/controle'), [
            'title' => 'TastyC',
            'user' => $user,
            'messages' => $messages,
            'comprados' => $comprados,
            'totalSemana' => $totalSemana,
            'totalMes' => $totalMes,
            'totalAno' => $totalAno,
            'totalDia' => $totalDia, 
    
        ]);    
    }

    
        

    public function store($request, $response, $args) {
        $idProd = $args['idrefeicao'];
        $idUser = $args['idUser'];
        

        $this->validate->exist($this->comprados, 'idrefeicao', $idProd);
        $errors = $this->validate->getErrors();

        if ($errors)
        {
            Flash::flashes($errors);
            return \app\helpers\redirect($response, '/home');
        }
        $produto = $this->comprados->getProdutoById($idProd);
        $valorProduto = $produto['valor'] ?? 0;

        $created = $this->comprados->create([
            'usuarios_id' => $idUser,
            'refeicao_idrefeicao' => $idProd,
            'data' => date('Y-m-d'), 
            'valor' => $valorProduto
        ]);
    
        if ($created)
        {
            Flash::set('message', 'Item comprado com sucesso');

            return \app\helpers\redirect($response, '/home'); 
        }


        Flash::set('message', 'Ocorreu um erro ao realizar a compra');
        return \app\helpers\redirect($response, '/home');
    }

    public function destroy($request, $response, $args)
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);

        $iduser = $_SESSION['user_logged_data']['id'];
        $comprado = $this->comprados->findBy('idgasto', $id);

        if (!$comprado)
        {
            Flash::set('message', 'Produto não encontrado', 'danger');
            return \app\helpers\redirect($response, '/controle/' . $iduser);

        }

        $deleted = $this->comprados->delete('idgasto', $id);

        if ($deleted)
        {
            Flash::set('message', 'deletado com sucesso!');
            return \app\helpers\redirect($response, '/controle/' . $iduser);
        }

        Flash::set('message', 'Não foi possível deletar', 'danger');
        return \app\helpers\redirect($response, '/controle/' . $iduser);
}
}