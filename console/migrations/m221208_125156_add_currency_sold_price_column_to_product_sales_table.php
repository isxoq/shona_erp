<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_sales}}`.
 */
class m221208_125156_add_currency_sold_price_column_to_product_sales_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("product_sales", "currency_partner_price", $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("product_sales", "currency_partner_price");
    }
}
