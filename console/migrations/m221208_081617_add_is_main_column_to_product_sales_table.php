<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_sales}}`.
 */
class m221208_081617_add_is_main_column_to_product_sales_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("partner_shops", "is_main", $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("partner_shops", "is_main");
    }
}
