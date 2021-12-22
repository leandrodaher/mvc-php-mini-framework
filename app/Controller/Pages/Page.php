<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Page
{

    static public function getHeader()
    {
        return View::render('pages/header');
    }

    static public function getFooter()
    {
        return View::render('pages/footer');
    }

    /**
     * Método responsável por renderizar o layout da paginação
     * @param Request $request
     * @param Pagination $pagination
     * @return string
     */
    public static function getPagination($request, $pagination)
    {
        // paginas
        $pages = $pagination->getPages();

        // verifica a quantidade de páginas
        if (count($pages) <= 1) return '';

        // links
        $links = '';

        // url atual (em gets)
        $url = $request->getRouter()->getCurrentUrl();
        
        // get
        $queryParams = $request->getQueryParams();

        // rendriza os links
        foreach($pages as $page) {
            // altera a página
            $queryParams['page'] = $page['page'];

            // link
            $link = $url.'?'.http_build_query($queryParams);
            
            // view
            $links .= View::render('pages/pagination/links', [
                'page'      => $page['page'],
                'link'      => $link,
                'active'    => $page['current'] ? 'active' : ''
            ]);
        }

        // renderiza box de paginação
        return View::render('pages/pagination/box', [
            'links' => $links,
        ]);

    }

    public static function getPage($title, $content)
    {
        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
        ]);
    }
}
