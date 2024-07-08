<?php

namespace App;

class Helpers
{
    public static function formatarCamposSql($data)
    {
        $ar = [];

        foreach ($data as $key => $value) {
            $ar[] = " {$key} = '{$value}'";
        }

        return implode(',', $ar);
    }

    public static function base64ErlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    public static function base64ErlDecode($data)
    {
        return base64_decode($data);
    }
}
