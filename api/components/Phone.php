<?php

namespace api\components;

class Phone
{
    public static function clear($phoneNumber)
    {
        $tel = trim($phoneNumber);
        return strtr($tel, [
            "+" => '',
            " " => '',
            "(" => '',
            ")" => '',
            "-" => '',
        ]);
    }
}
