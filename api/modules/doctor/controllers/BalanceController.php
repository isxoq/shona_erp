<?php

namespace api\modules\doctor\controllers;
# User: isxoq
# Date: 06.11.2021
# Time: 11:51
# Year: 2021
# Project: tashxis.loc
# Full Name: Isxoqjon Axmedov
# Phone: +998936448111
use api\controllers\BaseController;
use common\models\Queue;
use common\models\QueueState;
use common\models\Transactions;
use hospital\models\Doctor;
use yii;
use yii\filters\auth\HttpHeaderAuth;

class BalanceController extends BaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpHeaderAuth::class,
        ];
        return $behaviors;
    }

    public function actionGetBalance()
    {
        $request = Yii::$app->request;
        $transactions = Transactions::find();

//        if ($request->get('all')) {
//
//        }

        return $this->success([
            'total_balance' => 1500000,
            'f_total_balance' => Yii::$app->formatter->asSum(1500000)
        ]);

    }

}