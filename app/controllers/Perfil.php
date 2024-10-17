<?php 
namespace app\controllers;

use app\classes\Flash;
use app\database\models\Usuario;

class Perfil extends Base {

    public function __construct()
    {
        $this->user = new Usuario;
    }

    public function index($request, $response, $args)
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);

        $user = $this->user->findBy('id', $id);

        if (!$user)
        {
            Flash::set('message', 'Usuário não encontrado', 'danger');
            return \app\helpers\redirect($response, '/perfil/' . $id);
        }
        $messages = Flash::getAll();

        return $this->getTwig()->render($response, $this->setView('site/perfil'), [
            'title' => 'Editar Conta',
            'user' => $user,
            'messages' => $messages
        ]);    
    }
    
    public function salvarfigurinha($request, $response, $args) {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);

        $checkboxes = [];

        // Lista os nomes dos checkboxes que você espera
        $checkboxNames = ['figura1', 'figura2', 'figura3', 'figura4', 'figura5', 'figura6'];

        foreach ($checkboxNames as $name) {
            // Obtém o valor do checkbox, se estiver presente
            $value = filter_input(INPUT_POST, $name, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            
            // Adiciona ao array de checkboxes com o nome como chave
            $checkboxes[$name] = $value;
        }

        $checkedCount = count(array_filter($checkboxes, function($value) {
            return $value === true;
        }));
        
        // Verifica se mais de um checkbox está marcado
        if ($checkedCount > 1) {
            Flash::set('message', 'Mais de uma ou nenhuma figurinha selecionada', 'danger');
            return \app\helpers\redirect($response, '/perfil/' . $id);
        } 
        
        $user = $this->user->findBy('id', $id);

        if (!$user)
        {
            Flash::set('message', 'Usuário não encontrado', 'danger');
            return \app\helpers\redirect($response, '/perfil/' . $id);
        }

        $selectedCheckboxes = array_filter($checkboxes, function($value) {
            return $value === true;
        });
        
        // Verifica quais checkboxes estão marcados
        if (!empty($selectedCheckboxes)) {
            foreach ($selectedCheckboxes as $name => $value) {
                $caminho = "/assets/imagens/" . $name . ".png";
                $created = $this->user->update(['fields' =>['icone' => $caminho],'where' => ['id' => $id]]);
    
                if ($created)
                {
                    Flash::set('message', 'salvo com sucesso');
        
                    return \app\helpers\redirect($response, '/perfil/' . $id); 
                }
        
        
                Flash::set('message', 'Ocorreu um erro ao salvar foto');
                return \app\helpers\redirect($response, '/perfil/' . $id);
            }
        } else {
            echo "Nenhum checkbox está marcado.";
        }

    }
}