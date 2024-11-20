<?php

session_start();

use app\classes\TwigGlobal;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

require '../vendor/autoload.php';

$app = AppFactory::create();

TwigGlobal::set('is_logged_in', $_SESSION['is_logged_in'] ?? '');
TwigGlobal::set('user', $_SESSION['user_logged_data'] ?? '');

require '../app/helpers/config.php';
require '../app/middlewares/logged.php';
require '../app/routes/site.php';
require '../app/routes/user.php';
require '../app/routes/entrar.php';

$methodOverrideMiddleware = new MethodOverrideMiddleware();
$app->add($methodOverrideMiddleware); 

$app->map(['GET', 'POST', 'DELETE', 'PATCH', 'PUT'], '/{routes:.+}', function ($request, $response) {
    $response->getBody()->write('Página não encontrada');
    return $response;
});

$app->run(new \Slim\Http\Request($app->getContainer(), 'GET', '0.0.0.0:8080'));
