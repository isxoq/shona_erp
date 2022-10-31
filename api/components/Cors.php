<?php
# User: isxoq
# Date: 25.09.2021
# Time: 12:37
# Year: 2021
# Project: tashxis.loc
# Full Name: Isxoqjon Axmedov
# Phone: +998936448111

namespace api\components;


class Cors
{
    public static function settings(): array
    {
        return [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                // restrict access to
                'Origin' => self::allowedDomains(),
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['*'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 0,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ];
    }

    private static function allowedDomains(): array
    {
        return [
            "http://localhost:3000",
            "https://localhost:8080",
            "http://localhost:8080",
            "https://tashxis-v1.netlify.app",
            "http://tashxis-v1.netlify.app",
            "https://localhost:3000",
            "https://tashxis-andijon.netlify.app",
            "http://tashxis-andijon.netlify.app",
            "https://tashxis-uz-andijan.netlify.app",
            "http://tashxis-uz-andijan.netlify.app",
            "https://tashxis-online-v1.netlify.app",
            "http://tashxis-online-v1.netlify.app",
            "https://tashxis-online-uz-v1.netlify.app",

            "https://hospital.tashxis.online",
            "http://hospital.tashxis.online",

        ];
    }
}
