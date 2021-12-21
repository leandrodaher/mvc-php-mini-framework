<?php

require __DIR__ . '/vendor/autoload.php';

function debug($var)
{
    echo ("<pre>");
    print_r($var);
    echo "</pre>";
}


use App\Http\Router;
use App\Utils\View;
use App\Utils\Environment;

// carrega variáveis de ambiente
Environment::load(__DIR__);

define('URL', getenv('URL'));

// inicializa as variaveis globais da View
View::init([
    'URL' => URL
]);

$router = new Router(URL);
include __DIR__ . '/routes/pages.php';
$router->run()->sendResponse();