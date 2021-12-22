<?php

namespace App\Http\Middleware;

Use App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogin
{
    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        // verifica se o usuário não está logado
        if (!SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/admin/login');
        }

        // continua a execução
        return $next($request);
    }
}