<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%network_types}}`.
 */
class m221031_013437_create_network_types_table extends \soft\db\Migration
{
    public $tableName = "network_types";
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
        $this->dropTable('{{%network_types}}');
    }
}
