<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Route\Router;
use App\Https\Request;

$router = new Router(new Request);

require_once __DIR__ . '/../app/routes.php';

$router->resolve();

var_dump($_SERVER['REQUEST_URI']);