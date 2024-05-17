<?php
namespace app\controllers;

use app\controllers\Base;


class Entrar extends Base
{
    public function create($request, $response, $args)
    {
        return $this->getTwig()->render($response, $this->setView('tastyC/cadastro'), [
            'title' => 'Cadastro',
            'nome' => 'Eduarda'
        ]);
    }
}