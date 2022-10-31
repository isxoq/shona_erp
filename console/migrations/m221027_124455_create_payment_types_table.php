<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_types}}`.
 */
class m221027_124455_create_payment_types_table extends \soft\db\Migration
{
    public $tableName = "payment_types";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "name" => $this->string(),
            "percent" => $this->tinyInteger()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_types}}');
    }
}
