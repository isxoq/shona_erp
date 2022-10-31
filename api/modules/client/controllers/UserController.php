<?php

namespace api\modules\client\controllers;

/*
Project Name: taxi.loc
File Name: UserController.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/30/2021 1:41 PM
*/


use api\components\Error;
use api\components\Sms;
use api\models\Profile;
use api\models\TempNumber;
use api\modules\client\models\Client;
use common\models\Districts;
use common\models\Quarters;
use common\models\Regions;
use common\models\User;
use yii;
use yii\web\Request;

class UserController extends BaseController
{

    /**
     * Yangi ro'yhatdan o'tish yoki kirish
     * @return array
     */
    public function actionRegister(): array
    {
        $phone = clearPhone(Yii::$app->request->post('phone'));

        $validate = $this->validateFields(Yii::$app->request, ['phone']);


        if ($validate['code'] != Error::SUCCESS) {
            return $validate;
        }

        $tempNumber = TempNumber::findOne(['phone_number' => $phone]);

        if ($tempNumber) {
            if (($tempNumber->expire_at - time()) <= 0) {
                $tempNumber->code = generateCode();
                $tempNumber->expire_at = time() + 120;
                $tempNumber->save();

                $tempNumber->sendSmsCode();


                return $this->success([
                    'expired_in' => $tempNumber->expire_at - time()
                ], Error::SUCCESS);
            } else {
                return $this->success([
                    'expired_in' => $tempNumber->expire_at - time()
                ], Error::SMS_ALREADY_SENT);
            }

        } else {
            $tempNumber = new TempNumber();
        }

        $tempNumber->phone_number = $phone;
        $tempNumber->code = generateCode();
        $tempNumber->expire_at = time() + 120;
        $tempNumber->save();

        $tempNumber->sendSmsCode();

        return $this->success([
            'expired_in' => $tempNumber->expire_at - time()
        ], Error::SUCCESS);
    }

    /**
     * Tasdiqlash
     * @return array
     * @throws \Throwable
     * @throws yii\base\Exception
     * @throws yii\db\StaleObjectException
     */
    public function actionVerifyCode(): array
    {

        $validate = $this->validateFields(Yii::$app->request, ['phone', 'code']);

        if (!$validate['code']) {
            return $validate;
        }

        $phone = clearPhone(Yii::$app->request->post('phone'));
        $code = Yii::$app->request->post('code');

        $tempNumber = TempNumber::findOne(['phone_number' => $phone]);

        if (!$tempNumber) {
            return $this->error(null, Error::CLIENT_NOT_FOUND);
        }

        if (($tempNumber->expire_at - time()) <= 0) {
            return $this->error(null, Error::OTP_EXPIRED);
        }

        if ($tempNumber->code != $code) {
            return $this->error([], Error::INVALID_OTP);
        }

        $login = $phone;

        $user = Client::find()->andWhere(['phone' => $phone, 'type_id' => User::TYPE_CLIENT])->one();

        if (!$user) {
            $user = new Client([
                'scenario' => User::SCENARIO_API_CREATE_CLIENT
            ]);
            $user->phone = $phone;
            $user->email = $phone;
            $user->username = $login;
            $user->password_hash = Yii::$app->security->generatePasswordHash("12345678_isx");
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->status = User::STATUS_ACTIVE;
            $user->type_id = User::TYPE_CLIENT;
            $user->save();

        }
        $tempNumber->delete();
        return $this->success($user);
    }

    public function actionAddProfileInfo()
    {

        $profile = new Profile();
        $profile->auth_key = Yii::$app->request->post('auth_key');
        $profile->first_name = Yii::$app->request->post('first_name');
        $profile->last_name = Yii::$app->request->post('last_name');
        $profile->father_name = Yii::$app->request->post('father_name');
        $profile->birth_date = Yii::$app->request->post('birth_date');
        $profile->gender = Yii::$app->request->post('gender');
        $profile->province_id = Yii::$app->request->post('province_id');
        $profile->region_id = Yii::$app->request->post('region_id');

        if ($profile->validate()) {
            $user = Client::findClientByAuthKey($profile->auth_key);
            if (!$user) {
                return $this->error(null, Error::CLIENT_NOT_FOUND);
            }

            $user->scenario = User::SCENARIO_API_ADD_PROFILE_CLIENT;
            $user->first_name = $profile->first_name;
            $user->last_name = $profile->last_name;
            $user->father_name = $profile->father_name;
            $user->birth_date = $profile->birth_date;
            $user->gender = $profile->gender;
            $user->province_id = $profile->province_id;
            $user->region_id = $profile->region_id;

            $user->imageFile = yii\web\UploadedFile::getInstanceByName('image');
            if ($user->imageFile) {
                $user->image = $user->uploadImage();
            }

            $user->save();
            return $this->success($user);

        } else {
            return $this->error($profile->errors, Error::VALIDATION_ERROR);
        }


    }

    /**
     * Fieldlar borligini tekshiradi
     * @param yii\web\Request $request
     * @param array $array
     * @return array|bool
     */
    private function validateFields(Request $request, array $array)
    {
        foreach ($array as $item) {
            if (!$request->post($item)) {
                return $this->error([
                    'required' => $item
                ], Error::VALIDATION_ERROR);
            }
        }
        return $this->success(null, Error::SUCCESS);
    }

    public function actionRegions()
    {
        $regions = Regions::find()->all();
        return $this->success($regions);
    }

    public function actionDistricts($region_id)
    {
        $districts = Districts::find()
            ->joinWith('region')
            ->andWhere(['regions.id' => $region_id])
            ->all();
        return $this->success($districts);
    }

    public function actionQuarters($district_id)
    {
        $quarters = Quarters::find()
            ->joinWith('district')
            ->andWhere(['districts.id' => $district_id])
            ->all();
        return $this->success($quarters);
    }

    public function actionTest()
    {
        $r = Sms::sendSms("998936448111", "asdasd");
        return $r;
    }

}