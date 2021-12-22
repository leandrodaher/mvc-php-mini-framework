<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Controller\Pages\Page;
use App\Model\Entity\Testimony as EntityTestimony;

class Testimony extends Page
{

    /**
     * Método responsável por obter a renderização dos intens de depoimentos para a página
     * @return string
     */
    private static function getTestimoniesItems()
    {
        // dpeoimentos
        $items = '';

        // resultados da página
        $results = EntityTestimony::getTestimonies(null, 'id DESC');

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

    public static function getTestimonies()
    {
        $content = View::render('pages/testimonies', [
            'items' => self::getTestimoniesItems()
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

        return self::getTestimonies();
    }
}