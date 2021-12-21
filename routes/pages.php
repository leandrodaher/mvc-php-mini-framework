<?php

// Middlewares

use \App\Http\Middleware\Queue as MiddlewareQueue;

// define o mapeamento de middlewares armazenando o estado na classe de forma estática
// dentro da classe pode-se chamar este dado usando 'self::$map' onde self é a classe em si (diferente do $this) e $map é a variável que armazena os dados abaixo.
MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class
]);

// define o mapeamento de middlewares padrões executados em todas as rotas
MiddlewareQueue::setDefault([
    'maintenance'
]);

use \App\Http\Response;
use \App\Controller\Pages;

$router->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

$router->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);

$router->get('/depoimentos', [
    function () {
        return new Response(200, Pages\Testimony::getTestimonies());
    }
]);

$router->post('/depoimentos', [
    function ($request) {
        debug($request);exit;
        return new Response(200, Pages\Testimony::getTestimonies());
    }
]);

// Ex.: http://localhost:8000/pagina/50/delete
$router->get('/pagina/{idPagina}/{acao}', [
    function ($idPagina, $acao) {
        return new Response(200, 'Página ' . $idPagina . ' | Ação ' . $acao);
    }
]);
