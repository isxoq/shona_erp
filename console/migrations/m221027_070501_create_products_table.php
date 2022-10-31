<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m221027_070501_create_products_table extends \soft\db\Migration
{
    /**
     * {@inheritdoc}
     */

    public $tableName = "products";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "name" => $this->string(),
            "price_usd" => $this->double(2),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
