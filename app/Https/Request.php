<?php

namespace App\Https;

class Request
{
    public function uri()
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

