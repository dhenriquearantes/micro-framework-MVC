<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Route\Router;
use App\Https\Request;

$router = new Router(new Request);

$router->registerRoute("", "GET", HomeController::class, "index");

$router->registerRoute("/user", "GET", UserController::class, "index");
$router->registerRoute("/user/{id}", "GET", UserController::class, "show");
$router->registerRoute("/user/store", "POST", UserController::class, "store");
$router->registerRoute("/user/remove/{id}", "DELETE", UserController::class, "remove");
$router->registerRoute("/user/edit/{id}", "PUT", UserController::class, "edit");
$router->registerRoute("/about", "GET", HomeController::class, "about");


$router->dispatcher();
