<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_sales}}`.
 */
class m221121_163710_add_count_column_to_product_sales_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("product_sales", "count", $this->smallInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
