<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%orders}}`.
 */
class m230625_041757_add_cancel_user_id_column_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("orders", "cancel_user_id", $this->text()->null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
