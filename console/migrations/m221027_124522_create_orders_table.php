<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m221027_124522_create_orders_table extends \soft\db\Migration
{
    public $tableName = "orders";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "name" => $this->string(),
            "payment_type" => $this->integer(),
            "client_id" => $this->integer(),
            "client_fullname" => $this->string(),
            "client_phone" => $this->string(),
            "client_address" => $this->string(),
            "amount" => $this->double(),
            "delivery_type" => $this->tinyInteger(),
            "delivery_price" => $this->double(),
            "network_id" => $this->tinyInteger(),
            "status" => $this->tinyInteger(),
            "order_type" => $this->tinyInteger(),
            "credit_file" => $this->string(),
            "partner_order_id" => $this->integer(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
