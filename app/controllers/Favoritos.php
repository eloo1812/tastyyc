<?php
namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Usuario;
use app\database\models\Cardapio;
use app\database\models\FavoritosModel;

class Favoritos extends Base {
    public function __construct()
    {
        $this->user = new Usuario;
        $this->validate = new Validate;
        $this->favoritos = new FavoritosModel;
        $this->produto = new Cardapio;
    }
    

    public function index($request, $response, $args) {
        $id = $args['id'];
        $user = $this->user->findBy('id', $id);

        $idUser = $_SESSION['user_logged_data']['id'];
        $messages = Flash::getAll();
        $produtos = $this->produto->getPrincipais();
        $idBeto = 3;
        $betos = $this->produto->getById($idBeto);

        $favoritos = $this->favoritos->getAllById($idUser);
        return $this->getTwig()->render($response, $this->setView('site/favoritos'), [
            'title' => 'TastyC',
            'user' => $user,
            'messages' => $messages,
            'produtos' => $produtos,
            'betos' => $betos,
            'favoritos' => $favoritos
        ]);    
    }

    public function store($request, $response, $args) {
        $idProd = $args['idrefeicao'];
        $idUser = $args['idUser'];

        if ($this->favoritos->findBy('idrefeicao', $idProd)) {
            Flash::set('message', 'Este produto já está nos favoritos', 'danger');
            return \app\helpers\redirect($response, '/home');
        }
    

        $this->validate->exist($this->favoritos, 'idrefeicao', $idProd);
        $errors = $this->validate->getErrors();

        if ($errors)
        {
            Flash::flashes($errors);
            return \app\helpers\redirect($response, '/home');
        }

        

        $created = $this->favoritos->create(['usuarios_id' => $idUser, 'idrefeicao' => $idProd]);
    
        if ($created)
        {
            Flash::set('message', 'Favoritado com sucesso');

            return \app\helpers\redirect($response, '/home'); 
        }


        Flash::set('message', 'Ocorreu um erro ao favoritar');
        return \app\helpers\redirect($response, '/home');
    }

    public function destroy($request, $response, $args)
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);

        $favorito = $this->favoritos->findBy('idfavoritos', $id);

        if (!$favorito)
        {
            Flash::set('message', 'Produto não encontrado', 'danger');
            return \app\helpers\redirect($response, '/home');
        }

        $deleted = $this->favoritos->delete('idfavoritos', $id);

        if ($deleted)
        {
            Flash::set('message', 'Desfavoritado com sucesso!');
            return \app\helpers\redirect($response, '/home');
        }

        Flash::set('message', 'Não foi possível desfavoritar', 'danger');
        return \app\helpers\redirect($response, '/home');
}


    

}
