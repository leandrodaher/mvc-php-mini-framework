<?php
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
    function ($request) {
        return new Response(200, Pages\Testimony::getTestimonies($request));
    }
]);

$router->post('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::insertTestimony($request));
    }
]);

// Ex.: http://localhost:8000/pagina/50/delete
$router->get('/pagina/{idPagina}/{acao}', [
    function ($idPagina, $acao) {
        return new Response(200, 'Página ' . $idPagina . ' | Ação ' . $acao);
    }
]);




// ////////////////////////////// //
// exemplo de rota com middleware específico para ela
$router->get('/middleware', [
    'middlewares' => [
        'teste'
    ],
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);