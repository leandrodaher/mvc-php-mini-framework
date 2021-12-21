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

define('URL', 'http://localhost:8000');

// inicializa as variaveis globais da View
View::init([
    'URL' => URL
]);

$router = new Router(URL);
include __DIR__ . '/routes/pages.php';
$router->run()->sendResponse();