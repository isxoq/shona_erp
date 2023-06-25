<?php

namespace console\controllers;

use common\models\Order;
use common\models\Orders;
use yii\console\Controller;

class OrderController extends Controller
{
    public $month;
    public $year;

    public function options($actionID)
    {
        return array_merge(parent::options($actionID), [
            'month', 'year'
        ]);
    }

    public function actionSalaryCalculate()
    {
        $dateString = $this->year . '-' . $this->month . '-01'; // Set the day to 01
        $lastDayOfMonth = date('Y-m-t');

        $orders = Orders::find()
            ->andWhere(['>=', "orders.created_at", strtotime($dateString)])
            ->andWhere(['<=', "orders.created_at", strtotime($lastDayOfMonth)])
            ->andWhere(['=', "orders.status", Orders::STATUS_DELIVERED])
            ->andWhere(['!=', "orders.payment_type", 6])
            ->all();

        foreach ($orders as $order) {
            Orders::runSalaryCalculate($order);
        }
    }

}