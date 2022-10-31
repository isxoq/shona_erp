<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%revenues}}`.
 */
class m221027_124556_create_revenues_table extends \soft\db\Migration
{
    public $tableName = "revenues";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "order_id" => $this->integer(),
            "amount" => $this->double(),
            "type" => $this->string()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%revenues}}');
    }
}
