<?php

use App\Controllers\HomeController;
use App\Route\Router;
use App\Https\Request;

$router = new Router(new Request);

$router->register("/", "GET", "HomeController", "index");
$router->register("/about", "GET", "HomeController", "about");

$router->dispatcher();