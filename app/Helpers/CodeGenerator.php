<?php

namespace App\Helpers;

class CodeGenerator
{
    public static function code()
    {
        $code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        return $code;
    }
}
