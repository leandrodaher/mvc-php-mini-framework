<?php

namespace App\Utils;

class View
{

    /**
     * Variáveis padrões da View
     * @var array
     */
    private static $vars = [];

    /**
     * Método responsável por definir os dados iniciais da classe
     * @param array $vars
     */
    public static function init($vars = [])
    {
        self::$vars = $vars;
    }

    /**
     * Responsavel por retonar o conteúdo de uma view
     * @param string
     * @return string
     */
    private static function getContentView($name)
    {

        $file = __DIR__ . '/../../resources/view/' . $name . ".html";

        return file_exists($file) ? file_get_contents($file) : file_get_contents(__DIR__ . '/../../resources/view/pages/404.html');
    }

    /**
     * Método responsavel por retornar o conteúdo renderizado de uma view
     * @param  string $view
     * @param  array $vars
     * @return string
     */
    public static function render($view, $vars = [])
    {
        $contentView = self::getContentView($view);

        // inclue as variáveis globais da view
        $vars = array_merge(self::$vars, $vars);

        $contentView = self::alter($contentView, $vars);

        return $contentView;
    }

    public static function get($page, $vars)
    {

        $contentView = self::getContentView('extends/' . $page, $vars);
        $contentView = self::alter($contentView, $vars);

        return $contentView;
    }

    public static function alter($contentView, $vars)
    {

        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return "{{" . $item . "}}";
        }, $keys);

        $contentView = str_replace($keys, array_values($vars), $contentView);

        return $contentView;
    }
}
