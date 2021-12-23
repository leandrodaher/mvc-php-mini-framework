<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Utils\View;
use App\Model\Entity\User as EntityUser;
use App\Model\Pagination;

class User extends Page
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
                return Alert::getSuccess('Usuário criado com sucesso!');
                break;

            case 'updated':
                return Alert::getSuccess('Usuário atualizado com sucesso!');
                break;

            case 'deleted':
                return Alert::getSuccess('Usuário excluído com sucesso!');
                break;

            case 'duplicated':
                return Alert::getDanger('O e-mail digitado já está sendo utilizado por outro usuário.');
                break;
        }
    }

    /**
     * Método responsável por obter a renderização dos intens de usuários para a página
     * @param Request $request
     * @param Pagination &$pagination - referência de memória
     * @return string
     */
    private static function getUsersItems($request, &$pagination)
    {
        // usuários
        $items = '';

        // quantidade total de registros
        $quantidadeTotal = EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
                ->qtd;
        
        // pagina atual
        $queryParams =  $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $pagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

        // resultados da página
        $results = EntityUser::getUsers(null, 'id DESC', $pagination->getLimit());

        // renderiza o item
        while ($user = $results->fetchObject(EntityUser::class)) {
            $items .= View::render('admin/modules/users/item', [
                'id'        => $user->id,
                'nome'      => $user->nome,
                'email'     => $user->email
            ]);
        }

        return $items;
    }

    /**
     * Método responsável por renderizar a view de listagem de usuários
     * @param Request $request
     * @return string
     */
    public static function getUsers($request)
    {
        // conteudo da home
        $content = View::render('admin/modules/users/index', [
            'items'         => self::getUsersItems($request, $pagination),
            'pagination'    => parent::getPagination($request, $pagination),
            'status'        => self::getStatus($request)
        ]);

        // retorna a página completa
        return parent::getPanel('Usuários Admin', $content, 'users');
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um novo usuário
     * @param Request $request
     * @return string
     */
    public static function getNewUserForm($request)
    {
        // conteudo do formulário
        $content = View::render('admin/modules/users/form', [
            'title'     => 'Cadastrar Usuário',
            'nome'      => '',
            'email'     => '',
            'senha'     => '',
            'status'    => self::getStatus($request),
        ]);

        // retorna a página completa
        return parent::getPanel('Cadastrar Usuário', $content, 'users');
    }

    /**
     * Método responsável por cadastrar um novo usuário no banco
     * @param Request $request
     * @return string
     */
    public static function setNewUser($request)
    {
        // dados do post
        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        // valida o email do usuário
        $user = EntityUser::getUserByEmail($email);
        if ($user instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users/new?status=duplicated');
        }

        // nova instancia de usuário
        $user = new EntityUser;
        $user->nome = $nome;
        $user->email = $email;
        $user->senha = password_hash($senha, PASSWORD_DEFAULT);
        $user->cadastrar();

        // retorna para a página de edição do usuário
        $request->getRouter()->redirect('/admin/users/'.$user->id.'/edit?status=created');
    }

    /**
     * Método responsável por retornar o formulário de edição de um novo usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditUserForm($request, $id)
    {
        // obtem o usuário do banco de dados
        $user = EntityUser::getUserById($id);
        
        // valida a instancia
        if (!$user instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        // conteudo do formulário
        $content = View::render('admin/modules/users/form', [
            'title'     => 'Editar Usuário '.$id,
            'nome'      => $user->nome,
            'email'     => $user->email,
            'senha'     => '',
            'status'    => self::getStatus($request)
        ]);

        // retorna a página completa
        return parent::getPanel('Cadastrar Usuário', $content, 'users');
    }

    /**
     * Método responsável por editar novo usuário no banco
     * @param Request $request
     * @return string
     */
    public static function setEditUser($request, $id)
    {
        // obtem o usuário do banco de dados
        $user = EntityUser::getUserById($id);
        
        // valida a instancia
        if (!$user instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        // dados do post
        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';
        
        // valida se email inserido já está atribuído a outro usuário
        $userEmail = EntityUser::getUserByEmail($email);
        if ($userEmail instanceof EntityUser && $userEmail->id != $id) {
            $request->getRouter()->redirect('/admin/users/'.$id.'/edit?status=duplicated');
        }

        // atualiza instancia de usuário
        $user->nome = $nome;
        $user->email = $email;
        $user->senha = password_hash($senha, PASSWORD_DEFAULT);
        $user->atualizar();

        // retorna para a página de edição do usuário
        $request->getRouter()->redirect('/admin/users/'.$user->id.'/edit?status=updated');
    }

    /**
     * Método responsável por retornar o formulário de exclusão de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteUserForm($request, $id)
    {
        // obtem o usuário do banco de dados
        $user = EntityUser::getUserById($id);
        
        // valida a instancia
        if (!$user instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        // conteudo do formulário
        $content = View::render('admin/modules/users/delete', [
            'nome'  => $user->nome,
            'email' => $user->email,
        ]);

        // retorna a página completa
        return parent::getPanel('Excluir Usuário', $content, 'users');
    }

    /**
     * Método responsável pela exclusão de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteUser($request, $id)
    {
        // obtem o usuário do banco de dados
        $user = EntityUser::getUserById($id);
        
        // valida a instancia
        if (!$user instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        // exclui o usuário
        $user->excluir();

        // retorna para a página de edição do usuário
        $request->getRouter()->redirect('/admin/users?status=deleted');
    }
}