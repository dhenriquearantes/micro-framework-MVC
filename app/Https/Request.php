<?php

namespace App\Https;

class Request
{
    private static array $requestBody;

    public function uri()
    {
        return rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getBody()
    {
        return json_decode(file_get_contents('php://input'), true);
    }



}

