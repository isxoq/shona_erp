<?php

namespace api\controllers;
/*
Project Name: taxi.loc
File Name: BaseController.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/30/2021 1:41 PM
*/

use api\components\Cors;
use api\components\Error;

class BaseController extends \yii\rest\Controller
{


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = Cors::settings();

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        $behaviors['verbFilter'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'login' => ['POST', 'OPTIONS'],
                'signup' => ['POST', 'OPTIONS'],
                'confirm-code' => ['POST', 'OPTIONS'],
                'finish' => ['POST', 'OPTIONS'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Successfull javob yuborish
     * @param $data
     * @param string $message
     * @return array
     */
    public function success($data, string $message = ""): array
    {
        return [
            'success' => true,
            "error_code" => 0,
            'message' => t($message),
            'data' => $data
        ];
    }

    /**
     * Topilmaga javob qaytarish
     * @return array
     */
    public function notFound(): array
    {
        return [
            'success' => true,
            "error_code" => 404,
            'message' => t('Not found'),
            'data' => []
        ];
    }

    /**
     * Xatolik xabarini qaytarish
     * @param $data
     * @param string $message
     * @return array
     */
    public function error($data, $message = "", $code = 503): array
    {
        return [
            'success' => false,
            "error_code" => 503,
            'message' => t($message),
            'data' => $data
        ];
    }

}