<?php

namespace common\services;

use common\models\User;
use common\models\Orders;
use common\models\ProductSales;
use soft\helpers\ArrayHelper;

class SalaryService
{
    public static function getStaffMonthlyOrderSalary($from, $to, $user_id)
    {

        $revenue = static::getOrdersRevenue($from, $to, $user_id);

        $salary = 0;

        if (\Yii::$app->authManager->checkAccess($user_id, "Operator")) {
            $salary += $revenue * \Yii::$app->params['salary']['operator'] / 100;
        }

        if (\Yii::$app->authManager->checkAccess($user_id, "Diller")) {
            $salary += $revenue * \Yii::$app->params['salary']['diller'] / 100;
        }

        if (\Yii::$app->authManager->checkAccess($user_id, "Ta'minotchi")) {
            $salary += $revenue * \Yii::$app->params['salary']['taminotchi'] / 100;
        }

        return 1000000;

    }

    public static function getStaffMonthlyOrderSalesFine($from, $to, $user_id)
    {
        $revenue = static::getOrdersRevenue($from, $to, $user_id);

        $fine = 0;
        if (\Yii::$app->authManager->checkAccess($user_id, "Operator") || \Yii::$app->authManager->checkAccess($user_id, "Diller")) {
            if ($revenue < \Yii::$app->params['fines']['operator']) {
                $fine = (\Yii::$app->params['fines']['operator'] - $revenue) * 0.01;
            }
        }


//        if (\Yii::$app->authManager->checkAccess($user_id, "Ta'minotchi")) {
//            $salary += $revenue * \Yii::$app->params['salary']['taminotchi'] / 100;
//        }


        return $fine;

    }

    public static function getStaffMonthlyOrderSalesBonus($from, $to, $user_id)
    {


        $ordersQuery = static::getUserOrdersQueryDateInterval($from, $to, $user_id);

        $orders = $ordersQuery
            ->distinct("orders.id")
            ->andWhere(["=", "orders.status", Orders::STATUS_DELIVERED]);
//            ->andWhere(["!=", "orders.status", Orders::STATUS_CANCELLED])
//            ->andWhere(["!=", "orders.status", Orders::STATUS_HAS_PROBLEM]);

        $revenue = 0;
        $prePrice = 0;
        $bonus = 0;
        $jarima = 0;
        foreach ($orders->all() as $item) {
            if ($item->benefit > 0) {
                $revenue += $item->benefit;
                $prePrice += $item->buyPrice;
            } else {
                $jarima += $item->benefit;
            }
        }

        $bonus = 0;
        if (\Yii::$app->authManager->checkAccess($user_id, "Ta'minotchi")) {
            $bonus += $revenue * \Yii::$app->params['salary']['taminotchi'] / 100;
            return $bonus;
        }

        if ($prePrice) {
            $percent = ($revenue / $prePrice) * 100;
        }


        if ($prePrice <= 5) {
            $bonus = $revenue * 0.05;
        } elseif ($percent > 5 && $percent < 15) {
            $bonus = $revenue * 0.08;
        } elseif ($percent >= 15) {
            $bonus = $revenue * 0.15;
        }

        return $bonus + $jarima;

    }

    public static function getOrdersRevenue($from, $to, $user_id)
    {
        $ordersQuery = static::getUserOrdersQueryDateInterval($from, $to, $user_id);

        $totalProductsBuyQuery = clone $ordersQuery;
        $totalProductsSaleQuery = clone $ordersQuery;

        $totalProductsBuy = $totalProductsBuyQuery
            ->sum("product_sales.partner_shop_price*product_sales.count");


        $totalProductsSell = $totalProductsSaleQuery
            ->sum("product_sales.sold_price*product_sales.count");

        $revenue = $totalProductsSell - $totalProductsBuy;

        return $revenue;
    }


    public static function getUserOrdersQueryDateInterval($from, $to, $user_id)
    {

        $orders = Orders::find()
            ->andWhere(['>=', "orders.created_at", $from])
            ->andWhere(['<=', "orders.created_at", $to])
            ->joinWith("salesProducts");

        if (\Yii::$app->authManager->checkAccess($user_id, "Operator")) {
            $orders->andWhere(['=', 'orders.operator_diller_id', $user_id]);
        } elseif (\Yii::$app->authManager->checkAccess($user_id, "Diller")) {
            $orders->andWhere(['=', 'orders.operator_diller_id', $user_id]);
        }
        if (\Yii::$app->authManager->checkAccess($user_id, "Ta'minotchi")) {
            $orders->andWhere(['=', 'orders.taminotchi_id', $user_id]);
        }

        return $orders;
    }


}