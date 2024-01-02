<?php

namespace common\components;

use common\models\Clients;
use common\models\Order;
use common\models\Orders;
use yii\db\Query;
use yii\helpers\ArrayHelper;


class Statistics
{

    public static function newOrdersCount()
    {
        return Orders::find()->andWhere(['status' => Orders::STATUS_NEW])->count();
    }

    public static function ordersCount()
    {
        return Orders::find()->count();
    }

    public static function clientsCount()
    {
        return Clients::find()->count();
    }

    public static function dateRevenue($start = null, $end = null)
    {

        if (!$start) {
            $start = strtotime(date("Y-m-1 00:00:00"));
        } else {
            $start = strtotime($start);
        }

        if (!$end) {
            $end = strtotime(date("Y-m-t 23:59:59"));
        } else {
            $end = strtotime($end);
        }

        $revenue = Orders::find()
            ->andWhere(['>=', "created_at", $start])
            ->andWhere(['<=', "created_at", $end])
            ->sum("amount");

        return $revenue;
    }

    public static function dateFoyda($start = null, $end = null)
    {
        if (!$start) {
            $start = strtotime(date("Y-m-1 00:00:00"));
        } else {
            $start = strtotime($start);
        }

        if (!$end) {
            $end = strtotime(date("Y-m-t 23:59:59"));
        } else {
            $end = strtotime($end);
        }

        $benefit = 0;
        $orders = Orders::find()
            ->andWhere(['>=', "created_at", $start])
            ->andWhere(['<=', "created_at", $end])
            ->all();
        foreach ($orders as $order) {
            foreach ($order->salesProducts as $salesProduct) {
                $benefit += ($salesProduct->sold_price - $salesProduct->partner_shop_price) * $salesProduct->count;
            }
            $benefit -= $order->delivery_price;
        }

        return $benefit;
    }

    public static function calculateOrdersSales($models)
    {
        $ids = ArrayHelper::getColumn($models, 'id');
        $totalSale = (new Query())
            ->select('SUM(orders.amount) as totalSale')
            ->from('orders')
//            ->join('INNER JOIN', 'product_sales', 'orders.id = product_sales.order_id')
//            ->groupBy(["orders.id"])
            ->where(['orders.id' => $ids])
            ->scalar();
        return $totalSale;
    }

    public static function calculateOrdersBenefits($models)
    {
        $ids = ArrayHelper::getColumn($models, 'id');

        $totalBenefitWithoutDelivery = (new Query())
            ->select([
                'totalBenefit' => 'SUM((product_sales.sold_price - product_sales.partner_shop_price) * product_sales.count)',
            ])
            ->from('orders')
            ->join('INNER JOIN', 'product_sales', 'orders.id = product_sales.order_id')
            ->where(['orders.id' => $ids])
            ->scalar();

        $totalDelivery = (new Query())
            ->select([
                'totalBenefit' => 'SUM(orders.delivery_price)',
            ])
            ->from('orders')
            ->where(['orders.id' => $ids])
            ->scalar();

        return $totalBenefitWithoutDelivery - $totalDelivery;
    }

}