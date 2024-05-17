<?php
namespace app\routes; //cntrl alt g

use app\controllers\Entrar;

$app->get('/cadastro', Entrar::class . ":create");

