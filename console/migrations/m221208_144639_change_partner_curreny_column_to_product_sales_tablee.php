<?php

use yii\db\Migration;

/**
 * Class m221208_144639_change_partner_curreny_column_to_product_sales_tablee
 */
class m221208_144639_change_partner_curreny_column_to_product_sales_tablee extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("product_sales", "currency_partner_price", $this->double());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221208_144639_change_partner_curreny_column_to_product_sales_tablee cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221208_144639_change_partner_curreny_column_to_product_sales_tablee cannot be reverted.\n";

        return false;
    }
    */
}
