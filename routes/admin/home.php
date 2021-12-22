<?php

use App\Http\Response;
use App\Controller\Admin;

$router->get('/admin', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request) {
        return new Response(200, Admin\Home::getHome($request));
    }
]);