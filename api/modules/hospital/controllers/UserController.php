<?php

namespace api\modules\hospital\controllers;

/*
Project Name: taxi.loc
File Name: UserController.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/30/2021 1:41 PM
*/


use api\controllers\BaseController;
use api\models\Profile;
use api\models\TempNumber;
use api\components\Cors;
use common\models\Districts;
use common\models\Quarters;
use common\models\Regions;
use common\models\User;
use hospital\models\Staff;
use yii\base\BaseObject;
use yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Inflector;

class UserController extends BaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();


        // re-add authentication filter
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpHeaderAuth::class,
                QueryParamAuth::class,
            ],
        ];

        $behaviors['authenticator']['except'] = [
            'login-reception',
            'regions',
            'districts',
            'quarters',
        ];

        return $behaviors;
    }

    /**
     * Login
     * @return array
     * @throws yii\base\InvalidConfigException
     */
    public function actionLoginReception()
    {

        $validate = $this->validateFields(Yii::$app->request, ['login', 'password']);

        if (!$validate['success']) {
            return $validate;
        }

        $username = Yii::$app->request->post('login');
        $password = Yii::$app->request->post('password');


        $user = Staff::findHospitalReception($username);

        if (!$user) {
            return $this->error([], t('User not found'));
        }

        if (Yii::$app->security->validatePassword($password, $user->password_hash)) {
            return $this->success($user);
        }
        return $this->error([], t('Username or password error'));

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

    /**
     * Regions
     * @return array
     */
    public function actionRegions()
    {
        $regions = Regions::find()->all();
        return $this->success($regions);
    }

    /**
     * Discricts
     * @return array
     */
    public function actionDistricts($region_id)
    {
        $districts = Districts::find()
            ->joinWith('region')
            ->andWhere(['regions.id' => $region_id])
            ->all();
        return $this->success($districts);
    }

    /**
     * Quarters
     * @return array
     */
    public function actionQuarters($district_id)
    {
        $quarters = Quarters::find()
            ->joinWith('district')
            ->andWhere(['districts.id' => $district_id])
            ->all();
        return $this->success($quarters);
    }

    public function actionInfo()
    {
        return $this->success(Staff::findOne(\user('id')));
    }

}