<?php
namespace app\routes;

use app\routes\user;
use app\controllers\Home;
use app\controllers\Mapa;
use app\controllers\Site;
use app\controllers\promo;
use app\controllers\Perfil;
use app\controllers\promo2;
use app\controllers\Search;
use app\controllers\Produto;
use app\controllers\Comentar;
use app\controllers\Controle;
use app\controllers\qrcodeSG;
use app\controllers\Favoritos;
use app\controllers\qrcodeGRE;
use app\controllers\CadastroCar;
use app\controllers\CadastroRes;
use app\controllers\comentarios;
use app\controllers\CadastroTipo;
use app\controllers\Restaurantes;
use app\controllers\RestaurantesAll;

$app->get('/', Home::class . ":index");
$app->get('/home', Site::class . ":index")->add($logged);

$app->get('/CadastroRes', CadastroRes::class . ":index")->add($logged); 
$app->post('/cadastrarRes', CadastroRes::class . ":cadastrar");

$app->get('/CadastroCardapio', CadastroCar::class . ":index")->add($logged); 
$app->post('/cadastrarCardapio', CadastroCar::class . ":cadastrar");

$app->get('/CadastroTipo', CadastroTipo::class . ":index")->add($logged); 
$app->post('/cadastrarTipo', CadastroTipo::class . ":cadastrar");

$app->get('/promo', promo::class . ":index")->add($logged); 
$app->get('/promo2', promo2::class . ":index")->add($logged); 
$app->get('/qrcodeSG', qrcodeSG::class . ":index")->add($logged); 
$app->get('/qrcodeGRE', qrcodeGRE::class . ":index")->add($logged); 
$app->get('/RestaurantesAll', RestaurantesAll::class . ":index")->add($logged); 
$app->get('/Restaurantes/{id}', Restaurantes::class . ":index")->add($logged); 
$app->get('/comentarios', comentarios::class . ":index")->add($logged); 

$app->get('/perfil/{id}', Perfil::class . ":index")->add($logged); 

$app->get('/search', Search::class . ":index")->add($logged);


$app->post('/comentar', comentarios::class . ":store");

$app->get('/favoritos/{id}', Favoritos::class . ":index")->add($logged); 
$app->post('/favoritar/{idrefeicao}/{idUser}', Favoritos::class . ":store");
$app->delete('/favoritos/delete/{id}', Favoritos::class . ":destroy");


$app->get('/controle/{idUser}', Controle::class . ":index")->add($logged); 
$app->post('/controle/{idrefeicao}/{idUser}', Controle::class . ":store");
$app->delete('/controle/delete/{id}', Controle::class . ":destroy");

$app->post('/salvarFigura/{id}', Perfil::class . ":salvarfigurinha");

$app->get('/produto/{id}', Produto::class . ":index")->add($logged); 

$app->get('/chegar/{id}', Mapa::class . ":index")->add($logged); 
