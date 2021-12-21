<?php

namespace App\Http\Middleware;

class Queue
{
    /**
     * Mapeamento de middlewares
     * @var array
     */
    private static $map = [];

    /**
     * Mapeamento de middlewares que serão carregados em todas as rotas
     * @var array
     */
    private static $default = [];

    /**
     * Fila de middlewares a serem executados
     * @var array
     */
    private $middlewares = [];

    /**
     * Função de execução do controlador
     * @var Closure
     */
    private $controller;

    /**
     * Argunmentos da função do controlador
     * @var array
     */
    private $controllerArgs = [];

    /**
     * Método responsável por construir a classe de fila de middlewares
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs)
    {
        // coloca os middlewares deault em primeiro na fila e depois os middlewares da rota
        $this->middlewares      = array_merge(self::$default, $middlewares);
        $this->controller       = $controller;
        $this->controllerArgs   = $controllerArgs;
    }

    /**
     * Método responsável por definir o mapeamento de middlewares
     * @param array $map
     */
    public static function setMap($map)
    {
        // ver arquivo: routes/web.php
        self::$map = $map;
    }

    /**
     * Método responsável por definir o mapeamento de middlewares padrões
     * @param array $default
     */
    public static function setDefault($default)
    {
        // ver arquivo: routes/web.php
        self::$default = $default;
    }

    /**
     * Método responsável por executar o próximo nível da fila de middlewares
     * @param Request $request
     * @return Response
     */
    public function next($request)
    {
        // verifica se a fila está vazia
        if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

        // middleware
        $middleware = array_shift($this->middlewares);

        // verifica o mapeamento
        if (!isset(self::$map[$middleware])) {
            throw new \Exception("Problemas ao processar o middleware da requisição", 500);
        }

        // next
        $queue = $this; // necessário pois não se consegue passar this em função anônima (closure), mas pode-se apontar uma variavel para esta instância (this) e passar para a closure com o "use"
        // https://www.php.net/manual/pt_BR/functions.anonymous.php
        // https://stackoverflow.com/questions/22112829/php-this-context-in-anonymous-function
        
        $next = function($request) use($queue) {
            return $queue->next($request);
        };

        // executa o middleware
        return (new self::$map[$middleware])->handle($request, $next);
    }
}