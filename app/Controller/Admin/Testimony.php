<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;
use App\Model\Pagination;

class Testimony extends Page
{

    /**
     * Método responsável por retornar a mensagem de status
     * @param Request $request
     * @return string
     */
    private static function getStatus($request)
    {
        $queryParams = $request->getQueryParams();

        // se status não existe na query params da URL retorna vazio
        if (!isset($queryParams['status'])) return '';

        // mensagens de status
        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Depoimento criado com sucesso!');
                break;

            case 'updated':
                return Alert::getSuccess('Depoimento atualizado com sucesso!');
                break;

            case 'deleted':
                return Alert::getSuccess('Depoimento excluído com sucesso!');
                break;
        }
    }

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
            'pagination'    => parent::getPagination($request, $pagination),
            'status'        => self::getStatus($request)
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
        // conteudo do formulário
        $content = View::render('admin/modules/testimonies/form', [
            'title'     => 'Cadastrar Depoimento',
            'nome'      => '',
            'mensagem'  => '',
            'status'    => '',
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

    /**
     * Método responsável por retornar o formulário de edição de um novo depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditTestimonyForm($request, $id)
    {
        // obtem o depoimento do banco de dados
        $testimony = EntityTestimony::getTestimonyById($id);
        
        // valida a instancia
        if (!$testimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        // conteudo do formulário
        $content = View::render('admin/modules/testimonies/form', [
            'title'     => 'Editar Depoimento '.$id,
            'nome'      => $testimony->nome,
            'mensagem'  => $testimony->mensagem,
            'status'    => self::getStatus($request)
        ]);

        // retorna a página completa
        return parent::getPanel('Cadastrar Depoimento', $content, 'testimonies');
    }

    /**
     * Método responsável por editar novo depoimento no banco
     * @param Request $request
     * @return string
     */
    public static function setEditTestimony($request, $id)
    {
        // obtem o depoimento do banco de dados
        $testimony = EntityTestimony::getTestimonyById($id);
        
        // valida a instancia
        if (!$testimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        // dados do post
        $postVars = $request->getPostVars();

        // atualiza instancia de depoimento
        $testimony->nome = $postVars['nome'] ?? $testimony->nome;
        $testimony->mensagem = $postVars['mensagem'] ?? $testimony->mensagem;
        $testimony->atualizar();

        // retorna para a página de edição do depoimento
        $request->getRouter()->redirect('/admin/testimonies/'.$testimony->id.'/edit?status=updated');
    }

    /**
     * Método responsável por retornar o formulário de exclusão de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteTestimonyForm($request, $id)
    {
        // obtem o depoimento do banco de dados
        $testimony = EntityTestimony::getTestimonyById($id);
        
        // valida a instancia
        if (!$testimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        // conteudo do formulário
        $content = View::render('admin/modules/testimonies/delete', [
            'nome'      => $testimony->nome,
            'mensagem'  => $testimony->mensagem,
        ]);

        // retorna a página completa
        return parent::getPanel('Excluir Depoimento', $content, 'testimonies');
    }

    /**
     * Método responsável pela exclusão de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteTestimony($request, $id)
    {
        // obtem o depoimento do banco de dados
        $testimony = EntityTestimony::getTestimonyById($id);
        
        // valida a instancia
        if (!$testimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        // exclui o depoimento
        $testimony->excluir();

        // retorna para a página de edição do depoimento
        $request->getRouter()->redirect('/admin/testimonies?status=deleted');
    }
}