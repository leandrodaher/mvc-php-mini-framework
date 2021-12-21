<?php

require __DIR__ . '/vendor/autoload.php';

function debug($var)
{
    echo ("<pre>");
    print_r($var);
    echo "</pre>";
}


use \App\Controller\Pages\Home;

echo Home::getHome();
