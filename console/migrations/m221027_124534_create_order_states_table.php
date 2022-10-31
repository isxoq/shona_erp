<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_states}}`.
 */
class m221027_124534_create_order_states_table extends \soft\db\Migration
{
    public $tableName = "order_states";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "order_id" => $this->integer(),
            "user_id" => $this->integer(),
            "state_id" => $this->integer()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_states}}');
    }
}
