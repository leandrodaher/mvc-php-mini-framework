<?php

use App\Http\Response;
use App\Controller\Admin;

// rota de listagem de depoimentos
$router->get('/admin/depoimentos', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getTestimonies($request));
    }
]);