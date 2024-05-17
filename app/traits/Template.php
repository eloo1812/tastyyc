<?php
namespace app\traits;

use Exception;
use Slim\Views\Twig;

trait Template
{
    public function getTwig(){
        try {
            return $twig = Twig::create(DIR_VIEWS); //, ['cache' => 'path/to/cache']);
            return $twig;
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function setView($name) {
        return $name . EXT_VIEWS;
    }
}