<?php

use App\Http\Response;
use App\Controller\Admin;

// rota de listagem de usuários
$router->get('/admin/users', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request) {
        return new Response(200, Admin\User::getUsers($request));
    }
]);

// rota de formulário de cadastro de um novo usuário
$router->get('/admin/users/new', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request) {
        return new Response(200, Admin\User::getNewUserForm($request));
    }
]);

// rota de cadastro (post) de um novo usuário
$router->post('/admin/users/new', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request) {
        return new Response(200, Admin\User::setNewUser($request));
    }
]);

// rota de formulário de edição de um usuário
$router->get('/admin/users/{id}/edit', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::getEditUserForm($request, $id));
    }
]);

// rota de edição de um usuário
$router->post('/admin/users/{id}/edit', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::setEditUser($request, $id));
    }
]);

// rota de formulário de exclusão de um usuário
$router->get('/admin/users/{id}/delete', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::getDeleteUserForm($request, $id));
    }
]);

// rota de exclusão de um usuário
$router->post('/admin/users/{id}/delete', [
    'middlewares' => [
        'requeredAdminLogin'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::setDeleteUser($request, $id));
    }
]);