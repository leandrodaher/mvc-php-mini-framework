<?php

namespace App\Http;

class Response
{

    /**
     * Codígo Http da resposta
     * @var integer
     */
    private $httpCode = 200;

    /**
     * Headers da resposta
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteúdo da pagína
     * @var string
     */
    private $contentType = "text/html";

    /**
     * Conteúdo da nossa pagína
     * @var mixed
     */
    private $content;

    /**
     * Contrutor da classe 
     * @param integer $httpCode
     * @param mixed   $content
     * @param string  $contentType
     */
    public function __construct($httpCode, $content, $contentType = "text/html")
    {

        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->headers = getallheaders();
        $this->setContentType($contentType);
    }

    /**
     * Função que define o content-type da resposta
     * @param string $contentType
     */
    public function setContentType($contentType)
    {

        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Função que adiciona um header
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value)
    {

        $this->headers[$key] = $value;
    }

    /**
     * Executa os headers
     */
    private function sendHeaders()
    {

        http_response_code($this->httpCode);
        header('Content-Type: '.$this->contentType);
        // foreach ($this->headers as $key => $value) {

        //     header($key . ": " . $value);
        // }
    }

    /**
     * Mostra o conteúdo para o usúario
     */
    public function sendResponse()
    {

        $this->sendHeaders();

        switch ($this->contentType) {

            case 'text/html':
                echo $this->content;
                break;
        }
    }
}
