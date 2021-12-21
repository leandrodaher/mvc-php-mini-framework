<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Controller\Pages\Page;
use App\Model\Entity\Organization;

class Home extends Page
{

    static public function getHome()
    {
        $obOrganization = new Organization;

        $content = View::render('pages/home', [
            'name'          => $obOrganization->name,
            'description'   => $obOrganization->description,
            'site'          => $obOrganization->site
        ]);

        return parent::getPage('Teste de Título', $content);
    }
}
