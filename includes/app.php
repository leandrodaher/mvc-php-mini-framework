<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Utils\View;
use App\Utils\Environment;
use App\Model\DatabaseManager;
use App\Http\Middleware\Queue as MiddlewareQueue;

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

// define o mapeamento de middlewares armazenando o estado na classe de forma estática
// dentro da classe pode-se chamar este dado usando 'self::$map' onde self é a classe em si (diferente do $this) e $map é a variável que armazena os dados abaixo.
MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class,
    'teste' => \App\Http\Middleware\Teste::class
]);

// define o mapeamento de middlewares padrões (executados em todas as rotas)
MiddlewareQueue::setDefault([
    'maintenance'
]);