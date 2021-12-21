<?php

namespace App\Http;

class Request
{

    /**
     * Método HTTP usada para a requisição da pagína
     * @var string
     */
    private $httpMethod;

    /**
     * Url completa da pagína
     * @var string
     */
    private $uri;

    /**
     * Query Params ($_GET)
     * @var array
     */
    private $queryParams = [];

    /**
     * Posts Vars ($_POST)
     * @var array
     */
    private $postVars = [];

    /**
     * headers da página
     * @var array
     */
    private $headers;

    /**
     * Construtor que popula as variaveis
     */
    public function __construct()
    {

        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    /**
     * Obtem o Método http da requisição
     * @return string
     */
    public function getHttpMethod()
    {

        return $this->httpMethod;
    }

    /**
     * Obtem a URL completa da requisição
     * @return string
     */
    public function getUri()
    {

        return $this->uri;
    }

    /**
     * Obtem a varias GET da requisição
     * @return array
     */
    public function getQueryParams()
    {

        return $this->queryParams;
    }

    /**
     * Obtem as variaveis POST da requisição
     * @return array
     */
    public function getPostVars()
    {

        return $this->postVars;
    }

    /**
     * Obtem os headers da requisição
     * @return array
     */
    public function getHeaders()
    {

        return $this->headers;
    }
}
