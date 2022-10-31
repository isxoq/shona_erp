<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expense_types}}`.
 */
class m221027_124652_create_expense_types_table extends \soft\db\Migration
{
    public $tableName = "expense_types";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            "name" => $this->string()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%expense_types}}');
    }
}
