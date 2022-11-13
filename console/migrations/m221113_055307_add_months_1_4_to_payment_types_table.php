<?php

use yii\db\Migration;

/**
 * Class m221113_055307_add_months_1_4_to_payment_types_table
 */
class m221113_055307_add_months_1_4_to_payment_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn("payment_types", "month_1", $this->smallInteger());
        $this->addColumn("payment_types", "month_4", $this->smallInteger());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221113_055307_add_months_1_4_to_payment_types_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221113_055307_add_months_1_4_to_payment_types_table cannot be reverted.\n";

        return false;
    }
    */
}
