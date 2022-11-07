<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_types}}`.
 */
class m221107_170007_add_month_column_to_payment_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("payment_types", "month_3", $this->smallInteger());
        $this->addColumn("payment_types", "month_6", $this->smallInteger());
        $this->addColumn("payment_types", "month_9", $this->smallInteger());
        $this->addColumn("payment_types", "month_12", $this->smallInteger());
        $this->addColumn("payment_types", "month_15", $this->smallInteger());
        $this->addColumn("payment_types", "month_18", $this->smallInteger());
        $this->addColumn("payment_types", "month_24", $this->smallInteger());
        $this->addColumn("payment_types", "type", $this->smallInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("payment_types", "month_3");
        $this->dropColumn("payment_types", "month_6");
        $this->dropColumn("payment_types", "month_9");
        $this->dropColumn("payment_types", "month_12");
        $this->dropColumn("payment_types", "month_15");
        $this->dropColumn("payment_types", "month_18");
        $this->dropColumn("payment_types", "month_24");
        $this->dropColumn("payment_types", "type");
    }
}
