<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%partner_fees}}`.
 */
class m230313_174152_create_partner_fees_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%partner_fees}}', [
            'id' => $this->primaryKey(),
            "order_id" => $this->integer(),
            "payment_type" => $this->integer(),
            "amount" => $this->double()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%partner_fees}}');
    }
}
