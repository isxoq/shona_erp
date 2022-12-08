<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%partner_shop_pays}}`.
 */
class m221208_093504_create_partner_shop_pays_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%partner_shop_pays}}', [
            'id' => $this->primaryKey(),
            "partner_shop_id" => $this->integer(),
            "amount" => $this->integer(),
            "created_at" => $this->integer(),
            "updated_at" => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%partner_shop_pays}}');
    }
}
