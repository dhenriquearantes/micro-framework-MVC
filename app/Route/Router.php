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

    public function register($uri, $method, $controller, $action)
    {
        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatcher()
    {
        $method = $this->request->method();
        $uri = $this->request->uri();

        foreach ($this->routes as $route) {


            if ($route['uri'] == $uri && $route['method'] == $method) {
                $controllerName = $route['controller'];
                $action = $route['action'];
                $uri = $route['uri'];             

                $controller = new $controllerName;
                call_user_func_array([$controller, $action], []);

                return;
            } 


        }
    }
    
}