<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%partner_shops}}`.
 */
class m221027_124508_create_partner_shops_table extends \soft\db\Migration
{

    public $tableName = "partner_shops";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "name" => $this->string(),
            "phone" => $this->string(),
            "address" => $this->string(),
            "email" => $this->string()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%partner_shops}}');
    }
}
