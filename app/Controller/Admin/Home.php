<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Utils\View;

class Home extends Page
{

    /**
     * Método responsável por retornar a renderização da página de administração
     * @param Request $request
     * @return string
     */
    public static function getHome($request)
    {
        // conteudo da home
        $content = View::render('admin/modules/home/index');

        // retorna a página completa
        return parent::getPanel('Home Admin', $content, 'home');
    }
}