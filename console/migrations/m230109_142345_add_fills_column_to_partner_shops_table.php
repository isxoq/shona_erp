<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%partner_shops}}`.
 */
class m230109_142345_add_fills_column_to_partner_shops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("partner_shops", "base_imported", $this->double());
        $this->addColumn("partner_shops", "base_order_sold", $this->double());
        $this->addColumn("partner_shops", "base_debt", $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
