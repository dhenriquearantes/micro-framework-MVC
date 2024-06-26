<?php

use App\Controllers\HomeController;
use App\Route\Router;
use App\Https\Request;

$router = new Router(new Request);

$router->register("", "GET", HomeController::class, "index");
$router->register("/about", "GET", HomeController::class, "about");
$router->register("/items/{id}", "GET", HomeController::class, "items");

$router->dispatcher();