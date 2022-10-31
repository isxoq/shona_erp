<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\Order;
use soft\web\SoftController;
use yii\web\Response;

/**
 *
 * @property-read \common\models\Order[]|array $orders
 */
class ApiController extends SoftController
{

    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    public function actionGetOrders()
    {
        return $this->orders;
    }

    public function actionGetToken()
    {
        $user = User::findOne(Yii::$app->user->id);
        return $user ? $user->auth_key : null;
    }

    public function actionAddOrder()
    {
        $phone = Yii::$app->request->get('phone');
        $address = Yii::$app->request->get('address');
        if (Order::addOrder($phone, $address)) {
            return $this->orders;
        }
        return false;
    }

    /**
     * @return array|\common\models\Order[]
     */
    public function getOrders()
    {
        Yii::$app->params['orderFields'] = ['id', 'clientPhone', 'addressName', 'bsPrefix'];
        return Order::find()
            ->latest()
            ->with('address')
            ->all();
    }

}