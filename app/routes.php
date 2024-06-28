<?php

use App\Controllers\HomeController;
use App\Controllers\ItemController;
use App\Controllers\UserController;
use App\Route\Router;
use App\Https\Request;

$router = new Router(new Request);

$router->registerRoute("", "GET", HomeController::class, "index");

$router->registerRoute("/user", "GET", UserController::class, "show");
$router->registerRoute("/user/{id}", "GET", UserController::class, "showList");
$router->registerRoute("/user/create", "POST", UserController::class, "create");
$router->registerRoute("/user/delete/{id}", "DELETE", UserController::class, "delete");
$router->registerRoute("/user/update/{id}", "PUT", UserController::class, "update");

$router->registerRoute("/item/{id}", "GET", ItemController::class, "item");
$router->registerRoute("/about", "GET", HomeController::class, "about");


$router->dispatcher();
