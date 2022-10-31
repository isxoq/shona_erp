<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%states}}`.
 */
class m221027_124628_create_states_table extends \soft\db\Migration
{
    public $tableName = "states";
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
        $this->dropTable('{{%states}}');
    }
}
