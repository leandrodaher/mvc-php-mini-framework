<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Page
{
    /**
     * Módulos disponíveis no painel
     * @var array
     */
    private static $modules = [
        'home' => [
            'label' => 'Home',
            'link'  => URL.'/admin'
        ],
        'testimonies' => [
            'label' => 'Depoimentos',
            'link'  => URL.'/admin/testimonies'
        ],
        'users' => [
            'label' => 'Usuários',
            'link'  => URL.'/admin/users'
        ]
    ];

    /**
     * Método responsável por retornar o conteúdo (view) da estrutura genérica de página do painel
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('admin/page', [
            'title'     => $title,
            'content'   => $content
        ]);
    }

    /**
     * Método responsável por renderizar a view do menu do painel
     * @param string $currentModule
     * @return string
     */
    private static function getMenu($currentModule)
    {
        // links do menus
        $links = '';

        // iterar os modulos
        foreach(self::$modules as $hash => $module) {
            $links .= View::render('admin/menu/link', [
                'label'     => $module['label'],
                'link'      => $module['link'],
                'current'   => $hash == $currentModule ? 'menu-active' : ''
            ]);
        }

        // retorna a renderização do menu
        return View::render('admin/menu/box', [
            'links' => $links
        ]);
    }

    /**
     * Método responsável por renderizar a view do painel com conteúdos dinâmicos
     * @param string $title
     * @param string $content
     * @param string $currentModule
     * @return string
     */
    public static function getPanel($title, $content, $currentModule)
    {
        // renderiza a view do painel
        $contentPanel = View::render('admin/panel', [
            'menu'      => self::getMenu($currentModule),
            'content'   => $content
        ]);

        // retorna a página renderizada
        return self::getPage($title, $contentPanel);
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
            $links .= View::render('admin/pagination/links', [
                'page'      => $page['page'],
                'link'      => $link,
                'active'    => $page['current'] ? 'active' : ''
            ]);
        }

        // renderiza box de paginação
        return View::render('admin/pagination/box', [
            'links' => $links,
        ]);

    }
}