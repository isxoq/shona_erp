<?php

namespace api\modules\doctor\controllers;

/*
Project Name: taxi.loc
File Name: UserController.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/30/2021 1:41 PM
*/


use common\models\User;
use yii;
use yii\filters\auth\HttpHeaderAuth;

class UserController extends \api\controllers\BaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpHeaderAuth::class,
            'except' => ['login']
        ];
        return $behaviors;
    }

    /**
     * Login
     * @return array
     * @throws yii\base\InvalidConfigException
     */
    public function actionLogin()
    {

        $validate = $this->validateFields(Yii::$app->request, ['login', 'password']);

        if (!$validate['success']) {
            return $validate;
        }

        $username = Yii::$app->request->post('login');
        $username = clearPhone($username);
        $password = Yii::$app->request->post('password');

        $user = User::findDoctor($username);

        if (!$user) {
            return $this->error([], t('User not found'));
        }

        if (Yii::$app->security->validatePassword($password, $user->password_hash)) {
            return $this->success($user);
        }
        return $this->error([], t('Username or password error'));

    }


    public function actionGetInfo()
    {
        return $this->success(Yii::$app->user->identity);
    }

    /**
     * Fieldlar borligini tekshiradi
     * @param yii\web\Request $request
     * @param array $array
     * @return array|bool
     */
    private function validateFields(yii\web\Request $request, array $array)
    {
        foreach ($array as $item) {
            if (!$request->post($item)) {
                return $this->error([
                    'required' => $item
                ], t('Fields Required'));
            }
        }
        return $this->success([]);
    }

}