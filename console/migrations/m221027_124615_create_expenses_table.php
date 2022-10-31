<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expenses}}`.
 */
class m221027_124615_create_expenses_table extends \soft\db\Migration
{
    public $tableName = "expenses";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "type" => $this->tinyInteger(),
            "description" => $this->text(),
            "amount" => $this->double()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%expenses}}');
    }
}
