<?php

namespace App\Http\Middleware;

class Maintenance
{
    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        // converte a variavel ambiente de string para booleano
        $maintenance = filter_var(getenv('MAINTENANCE'), FILTER_VALIDATE_BOOLEAN);

        if($maintenance == true) {
            throw new \Exception("Página em manutenção. Tente novamente mais tarde.", 200);
        }

        return $next($request);
    }
}