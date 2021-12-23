<?php

namespace App\Model\Entity;

use App\Model\DatabaseManager;

class Testimony
{

    /**
     * ID do depoimento
     * @var integer
     */
    public $id;

     /**
     * Nome do usuário que fez o depoimento
     * @var string
     */
    public $nome;

     /**
     * Mensagem
     * @var string
     */
    public $mensagem;

     /**
     * Data de publicação
     * @var string
     */
    public $data;

     /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar()
    {
        $this->data = date('Y-m-d H:i:s');

        // insere o depoimento no banco de dados
        $this->id = (new DatabaseManager('depoimentos'))->insert([
            'nome'      => $this->nome,
            'mensagem'  => $this->mensagem,
            'data'      => $this->data,
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
        return (new DatabaseManager('depoimentos'))->update('id = '.$this->id, [
            'nome'      => $this->nome,
            'mensagem'  => $this->mensagem,
        ]);
    }

    /**
     * Método responsável por excluir a instância atual no banco de dados
     * @return boolean
     */
    public function excluir()
    {
        // exclui o depoimento no banco de dados
        return (new DatabaseManager('depoimentos'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por retornar depoimentos
     * @param string $where
     * @param string $order
     * @param int $limit
     * @param string fields
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new DatabaseManager('depoimentos'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por retornar um depoimento com base no seu id
     * @param integer $id
     * @return Testimony
     */
    public static function getTestimonyById($id)
    {
        return self::getTestimonies('id = '.$id)->fetchObject(self::class);
    }
}