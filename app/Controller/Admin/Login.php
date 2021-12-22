<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Utils\View;
use App\Model\Entity\User;
Use App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page
{

    /**
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     * @param string $errorMessage
     * @return string
     */
    public static function getLogin($request, $errorMessage = null)
    {
        // status
        $status = !is_null($errorMessage) ? View::render('admin/login/status', [
            'mensagem' => $errorMessage
        ]) : '';

        // conteudo da página de login
        $content = View::render('admin/login', [
            'status' => $status
        ]);

        // retorna a página completa
        return parent::getPage('Login', $content);
    }

    /**
     * Método responsável por definir o login do usuário
     * @param Reques $request
     */
    public static function setLogin($request)
    {
        // post vars
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        // busca o usuário pelo e-mail
        $user = User::getUserByEmail($email);

        // se o usuário não existir ou se a senha for incorreta
        if (!$user instanceof User || !password_verify($senha, $user->senha)) {
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }

        // cria a sessão de login
        SessionAdminLogin::login($user);

        // redireciona o usuário para a home do admin
        $request->getRouter()->redirect('/admin');
    }

    /**
     * Método responsável por deslogar o usuário
     * @param Request $request
     */
    public static function setLogout($request)
    {
        // destroi a sessão de login
        SessionAdminLogin::logout();

        // redireciona o usuário para a tela de login
        $request->getRouter()->redirect('/admin/login');
    }
}