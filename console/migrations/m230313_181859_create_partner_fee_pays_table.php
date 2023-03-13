<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%partner_fee_pays}}`.
 */
class m230313_181859_create_partner_fee_pays_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%partner_fee_pays}}', [
            'id' => $this->primaryKey(),
            "partner_id" => $this->integer(),
            "amount" => $this->double(),
            "created_at" => $this->integer(),
            "updated_at" => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%partner_fee_pays}}');
    }
}
