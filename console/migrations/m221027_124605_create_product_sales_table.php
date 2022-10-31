<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_sales}}`.
 */
class m221027_124605_create_product_sales_table extends \soft\db\Migration
{
    public $tableName = "product_sales";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "order_id" => $this->integer(),
            "product_id" => $this->integer(),
            "sold_price" => $this->double(),
            "product_source" => $this->tinyInteger(),
            "partner_shop_price" => $this->double(),
            "partner_shop_payed" => $this->tinyInteger(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_sales}}');
    }
}
