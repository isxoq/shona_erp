<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%expenses}}`.
 */
class m221209_145717_add_expenses_column_to_expenses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("expenses", "staff_id", $this->integer());
        $this->addColumn("expenses", "is_affect_salary", $this->smallInteger());
        $this->addColumn("expense_types", "is_staff", $this->smallInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("expenses", "staff_id");
        $this->dropColumn("expenses", "is_affect_salary");
        $this->dropColumn("expense_types", "is_staff");
    }
}
