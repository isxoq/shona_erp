<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%partner_shops}}`.
 */
class m221113_055703_add_kurs_column_to_partner_shops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("partner_shops", "currency", $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
