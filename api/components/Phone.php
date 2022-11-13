<?php

namespace api\components;

class Phone
{
    public static function clear($phoneNumber)
    {
        if ($phoneNumber) {
            $tel = trim($phoneNumber);
            return strtr($tel, [
                "+" => '',
                " " => '',
                "(" => '',
                ")" => '',
                "-" => '',
            ]);
        } else {
            return "";
        }
    }
}
