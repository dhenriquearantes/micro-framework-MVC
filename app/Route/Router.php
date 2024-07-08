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

    public function registerRoute($uri, $method, $controller, $action)
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
        $uri = $this->request->uri();
        $method = $this->request->method();
    
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([a-zA-Z0-9_-]+)', $route['uri']);
            $pattern = str_replace('/', '\/', $pattern);
    
            if (preg_match('/^' . $pattern . '$/', $uri, $matches) && $route['method'] == $method) {
                array_shift($matches); 

                if (is_numeric($matches[0])) {
                    $matches[0] = intval($matches[0]);
                }

                $controllerName = $route['controller'];
                $action = $route['action'];
    
                $controller = new $controllerName;

                $params = array_merge($matches, [$this->request]);
    
                call_user_func_array([$controller, $action], $params);
    
                return;
            }
        }
    
        $this->notFound();
    }
    


    public function notFound()
    {
        http_response_code(404);
        echo "Not Found";

    }
 
    

    
}