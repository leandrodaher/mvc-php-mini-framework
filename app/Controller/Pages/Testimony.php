<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Controller\Pages\Page;
use App\Model\Entity\Organization;

class Testimony extends Page
{

    static public function getTestimonies()
    {
        $obOrganization = new Organization;

        $content = View::render('pages/testimonies');

        return parent::getPage('DEPOIMENTOS', $content);
    }
}