<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require __DIR__.'/includes/app.php';

use App\Http\Router;

// inclue as rotas da aplicação
$router = new Router(URL);
include __DIR__ . '/routes/pages.php';
include __DIR__ . '/routes/admin.php';
$router->run()->sendResponse();