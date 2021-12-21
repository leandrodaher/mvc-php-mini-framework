<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Controller\Pages\Page;
use App\Model\Entity\Organization;

class About extends Page
{

    static public function getAbout()
    {
        $obOrganization = new Organization;

        $content = View::render('pages/about', [
            'name'          => $obOrganization->name
        ]);

        return parent::getPage('SOBRE', $content);
    }
}
