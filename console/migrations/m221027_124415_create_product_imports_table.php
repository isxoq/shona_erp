<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_imports}}`.
 */
class m221027_124415_create_product_imports_table extends \soft\db\Migration
{
    public $tableName = "product_imports";
    public $softDelete = true;
    public $timestamp = true;


    public function attributes()
    {

        return [
            'id' => $this->primaryKey(),
            "product_id" => $this->integer(),
            "partner_id" => $this->integer(),
            "import_price" => $this->double(2),
            "currency_price" => $this->double(2),
            "import_price_uzs" => $this->double(2),
            "quantity" => $this->integer()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_imports}}');
    }
}
