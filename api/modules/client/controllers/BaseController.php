<?php

namespace api\modules\client\controllers;
/*
File Name: BaseController.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/30/2021 1:41 PM
*/

use api\components\Error;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;

class BaseController extends \yii\rest\Controller
{





    /**
     * Successfull javob yuborish
     * @param $data
     * @param string $message
     * @return array
     */
    public function success($data, $error_code = Error::SUCCESS): array
    {
        return [
            'code' => $error_code,
            'message' => Error::getErrorMessage($error_code),
            'data' => $data ?? null
        ];
    }

    /**
     * Topilmagan javob qaytarish
     * @return array
     */
    public function notFound(): array
    {
        return [
            'code' => Error::NOT_FOUND,
            'message' => Error::getErrorMessage(Error::NOT_FOUND),
            'data' => null
        ];
    }

    /**
     * Xatolik xabarini qaytarish
     * @param $data
     * @param string $message
     * @return array
     */
    public function error($data, $error_code): array
    {
        return [
            'code' => $error_code,
            'message' => Error::getErrorMessage($error_code),
            'data' => $data ?? null
        ];
    }

}