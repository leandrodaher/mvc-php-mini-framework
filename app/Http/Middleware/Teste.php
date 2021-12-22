<?php

namespace App\Http\Middleware;

class Teste
{
    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        throw new \Exception("Este é um middleware de teste específico para uma rota. Tente novamente mais tarde.", 200);

        return $next($request);
    }
}