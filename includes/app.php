<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Utils\View;
use App\Utils\Environment;
use App\Model\DatabaseManager;

function debug($var)
{
    echo ("<pre>");
    print_r($var);
    echo "</pre>";
}

// carrega variáveis de ambiente
Environment::load(__DIR__.'/../');

// define as configurações do banco de dados
DatabaseManager::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT'),

    __DIR__.'/../database/database.sqlite'
);

define('URL', getenv('URL'));

// inicializa as variaveis globais da View
View::init([
    'URL' => URL
]);