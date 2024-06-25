<?php

namespace App\Route;

use App\Https\Request;

class Router
{
    protected $request;
    protected $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function resolve()
    {
        $method = $this->request->method();
        $uri = $this->request->uri();

        $controller = $this->routes[$method][$uri] ?? null;

        if (!$controller) {
            http_response_code(404);
            echo "404 - Not Found";
            return;
        }

        list($class, $method) = explode('@', $controller);

        if (class_exists($class) && method_exists($class, $method)) {
            call_user_func_array([new $class, $method], []);
        } else {
            http_response_code(500);
            echo "500 - Internal Server Error";
        }
    }
}
