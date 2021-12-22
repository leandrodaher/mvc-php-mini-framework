<?php

use App\Http\Response;
use App\Controller\Admin;

// rota de login
$router->get('/admin/login', [
    'middlewares' => [
        'requeredAdminLogout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

// rota de login (post)
$router->post('/admin/login', [
    'middlewares' => [
        'requeredAdminLogout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::setLogin($request));
    }
]);

// rota de logout
$router->get('/admin/logout', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request) {
        return new Response(200, Admin\Login::setLogout($request));
    }
]);