<?php

use App\Http\Response;
use App\Controller\Admin;

// rota de listagem de depoimentos
$router->get('/admin/testimonies', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getTestimonies($request));
    }
]);

// rota de formulário de cadastro de um novo depoimento
$router->get('/admin/testimonies/new', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getNewTestimonyForm($request));
    }
]);

// rota de cadastro (post) de um novo depoimento
$router->post('/admin/testimonies/new', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::setNewTestimony($request));
    }
]);

// rota de formulário de edição de um novo depoimento
$router->get('/admin/testimonies/edit', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getNewTestimonyForm($request));
    }
]);