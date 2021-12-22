<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Controller\Pages\Page;
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
            $items .= View::render('pages/testimony/item', [
                'id' => $testimony->id,
                'nome' => $testimony->nome,
                'mensagem' => $testimony->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($testimony->data))
            ]);
        }

        return $items;
    }

    /**
     * Método responsável por retornar o conteúdo (view) de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request)
    {
        $content = View::render('pages/testimonies', [
            'items'         => self::getTestimoniesItems($request, $pagination), // cria a variavel $pagination com valor nula, a função getTestimoniesItems irá receber como referência de memória pois está declarada com o token '&' na definição da função
            'pagination'    => parent::getPagination($request, $pagination)
        ]);

        return parent::getPage('DEPOIMENTOS', $content);
    }

    /**
     * Método responsáveol por cadastrar um depoimento
     * @param Request $request
     * @return
     */
    public static function insertTestimony($request)
    {
        // dados do post
        $postVars = $request->getPostVars();

        // nova instancia de depoimento
        $testimony = new EntityTestimony;
        $testimony->nome = $postVars['nome'];
        $testimony->mensagem = $postVars['mensagem'];
        $testimony->cadastrar();

        // retorna a página de listagem de depoimentos
        return self::getTestimonies($request);
    }
}