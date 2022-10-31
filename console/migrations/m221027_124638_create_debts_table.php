<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%debts}}`.
 */
class m221027_124638_create_debts_table extends \soft\db\Migration
{
    public $tableName = "debts";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "partner_id" => $this->integer(),
            "amount" => $this->double(),
            "description" => $this->text(),
            "type" => $this->tinyInteger()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%debts}}');
    }
}
