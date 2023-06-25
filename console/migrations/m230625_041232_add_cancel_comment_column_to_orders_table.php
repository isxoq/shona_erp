<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%orders}}`.
 */
class m230625_041232_add_cancel_comment_column_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("orders", "cancel_comment", $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
