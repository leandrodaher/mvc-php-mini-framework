<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;
use App\Model\Pagination;

class Testimony extends Page
{

    /**
     * Método responsável por obter a renderização dos intens de depoimentos para a página
     * @param Request $request
     * @param Pagination &$pagination - referência de memória
     * @return string
     */
    private static function getTestimoniesItems($request, &$pagination)
    {
        // depoimentos
        $items = '';

        // quantidade total de registros
        $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
                ->qtd;
        
        // pagina atual
        $queryParams =  $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $pagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

        // resultados da página
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $pagination->getLimit());

        // renderiza o item
        while ($testimony = $results->fetchObject(EntityTestimony::class)) {
            $items .= View::render('admin/modules/testimonies/item', [
                'id'        => $testimony->id,
                'nome'      => $testimony->nome,
                'mensagem'  => $testimony->mensagem,
                'data'      => date('d/m/Y H:i:s', strtotime($testimony->data))
            ]);
        }

        return $items;
    }

    /**
     * Método responsável por renderizar a view de listagem de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request)
    {
        // conteudo da home
        $content = View::render('admin/modules/testimonies/index', [
            'items'         => self::getTestimoniesItems($request, $pagination),
            'pagination'    => parent::getPagination($request, $pagination)
        ]);

        // retorna a página completa
        return parent::getPanel('Depoimentos Admin', $content, 'testimonies');
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um novo depoimento
     * @param Request $request
     * @return string
     */
    public static function getNewTestimonyForm($request)
    {
        // conteudo da home
        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Cadastrar Depoimento'
        ]);

        // retorna a página completa
        return parent::getPanel('Cadastrar Depoimento', $content, 'testimonies');
    }

        /**
     * Método responsável por cadastrar um novo depoimento no banco
     * @param Request $request
     * @return string
     */
    public static function setNewTestimony($request)
    {
        // dados do post
        $postVars = $request->getPostVars();

        // nova instancia de depoimento
        $testimony = new EntityTestimony;
        $testimony->nome = $postVars['nome'];
        $testimony->mensagem = $postVars['mensagem'];
        $testimony->cadastrar();

        // retorna para a página de edição do depoimento
        $request->getRouter()->redirect('/admin/testimonies/'.$testimony->id.'/edit?status=created');
    }
}