<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%delivery_types}}`.
 */
class m221027_124440_create_delivery_types_table extends \soft\db\Migration
{
    public $tableName = "delivery_types";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "name" => $this->string(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%delivery_types}}');
    }
}
