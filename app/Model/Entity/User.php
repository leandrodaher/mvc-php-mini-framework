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
     * Método responsável por retornar um usuário com base em seu e-mail
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return (new DatabaseManager('usuarios'))->select("email = '$email'")->fetchObject(self::class);
    }
}
