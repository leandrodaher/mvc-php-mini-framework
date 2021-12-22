<?php

namespace App\Session\Admin;

class Login
{

    /**
     * Métoo responsável por iniciar a sessão
     */
    private static function init()
    {
        // verifica se sessão não está ativa
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Método responsável por criar o login do usuáro
     * @param User $user
     * @return boolean
     */
    public static function login($user)
    {
        // inicia a sessão
        self::init();

        // define a sessão do usuário
        $_SESSION['admin']['usuario'] = [
            'id'    => $user->id,
            'nome'  => $user->nome,
            'email' => $user->email
        ];

        // sucesso
        return true;
    }

    /**
     * Método responsável por verificar se o usuário está logado
     * @return [type]
     */
    public static function isLogged()
    {
        // inicia a sessão
        self::init();

        // retorna a verificação
        return isset($_SESSION['admin']['usuario']['id']);
    }

    /**
     * Método responsável por executar o logout do usuário
     * @return boolean
     */
    public static function logout()
    {
        // inicia a sessão
        self::init();

        // desloga o usuário
        unset($_SESSION['admin']['usuario']);

        // sucesso
        return true;
    }
}