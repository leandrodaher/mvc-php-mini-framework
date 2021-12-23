<?php

namespace App\Model\Entity;

use App\Model\DatabaseManager;

class User
{

    /**
     * ID do usuário
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário
     * @var string
     */
    public $nome;

    /**
     * E-mail do usuário
     * @var string
     */
    public $email;

    /**
     * Hash da senha do usuário
     * @var string
     */
    public $senha;

     /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar()
    {
        // insere o depoimento no banco de dados
        $this->id = (new DatabaseManager('usuarios'))->insert([
            'nome'  => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha,
        ]);

        return true;
    }

     /**
     * Método responsável por atualziar a instância atual no banco de dados
     * @return boolean
     */
    public function atualizar()
    {
        // atualiza o depoimento no banco de dados
        return (new DatabaseManager('usuarios'))->update('id = '.$this->id, [
            'nome'      => $this->nome,
            'email'  => $this->email,
            'senha'  => $this->senha,
        ]);
    }

    /**
     * Método responsável por excluir a instância atual no banco de dados
     * @return boolean
     */
    public function excluir()
    {
        // exclui o depoimento no banco de dados
        return (new DatabaseManager('usuarios'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por retornar usuários
     * @param string $where
     * @param string $order
     * @param int $limit
     * @param string fields
     * @return PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new DatabaseManager('usuarios'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por retornar um depoimento com base no seu id
     * @param integer $id
     * @return User
     */
    public static function getUserById($id)
    {
        return self::getUsers('id = '.$id)->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar um usuário com base em seu e-mail
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return self::getUsers('email = "'.$email.'"')->fetchObject(self::class);
    }
}
