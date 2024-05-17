<?php

session_start();

use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware; //shift i

require '../vendor/autoload.php';

$app = AppFactory::create();

require '../app/helpers/config.php';
require '../app/routes/site.php';


$app->map(['GET', 'POST', 'DELETE', 'PATCH', 'PUT'], '/{routes:.+}', function ($request, $response) {
    $response->getBody()->write('Este endereço não existe');
    return $response;
});

$app->run();