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
$router->registerRoute("/user/delete/{id}", "DELETE", UserController::class, "delete");
$router->registerRoute("/user/update/{id}", "PUT", UserController::class, "update");
$router->registerRoute("/about", "GET", HomeController::class, "about");


$router->dispatcher();
