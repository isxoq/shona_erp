<?php

namespace common\services;

use common\models\Orders;
use common\models\ProductSales;

class SalaryService
{
    public static function getOperatorMonthlyOrderSalary($from, $to, $operator_id)
    {
        $orders = Orders::find()
            ->andWhere(['>=', "created_at", $from])
            ->andWhere(['<=', "created_at", $to])
            ->sum("amount");

        $productsBuy = Orders::find()
            ->andWhere(['>=', "orders.created_at", $from])
            ->andWhere(['<=', "orders.created_at", $to])
            ->joinWith("salesProducts")
            ->sum("product_sales.partner_shop_price*product_sales.count");


        $productsSell = Orders::find()
            ->andWhere(['>=', "orders.created_at", $from])
            ->andWhere(['<=', "orders.created_at", $to])
            ->joinWith("salesProducts")
            ->sum("product_sales.sold_price*product_sales.count");

        dump($productsSell);
        return $orders;
    }
}