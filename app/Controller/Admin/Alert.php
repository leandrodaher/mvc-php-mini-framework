<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Alert
{

    /**
     * Método responsável por retornar uma manesagem de sucesso
     * @param string $string
     * @return string
     */
    public static function getSuccess($message)
    {
        return View::render('admin/alert/status', [
            'tipo'     => 'success',
            'mensagem'  => $message
        ]);
    }

    /**
     * Método responsável por retornar uma manesagem de erro
     * @param string $string
     * @return string
     */
    public static function getDanger($message)
    {
        return View::render('admin/alert/status', [
            'tipo'     => 'danger',
            'mensagem'  => $message
        ]);
    }
}