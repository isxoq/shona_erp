<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_revenue}}`.
 */
class m230624_123941_create_user_revenue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_revenue}}', [
            'id' => $this->primaryKey(),
            "order_id" => $this->integer()->null(),
            "user_id" => $this->integer()->null(),
            "amount" => $this->double(2)->null(),
            "comment" => $this->text()->null(),
            "type" => $this->tinyInteger()->null(),
            "status" => $this->tinyInteger()->null(),
            "created_at" => $this->integer(),
            "updated_at" => $this->integer()
        ]);
        $this->createTable('{{%user_fine}}', [
            'id' => $this->primaryKey(),
            "order_id" => $this->integer()->null(),
            "user_id" => $this->integer()->null(),
            "amount" => $this->double(2)->null(),
            "comment" => $this->text()->null(),
            "created_at" => $this->integer(),
            "updated_at" => $this->integer()
        ]);
        $this->createTable('{{%user_salary}}', [
            'id' => $this->primaryKey(),
            "user_id" => $this->integer()->null(),
            "month" => $this->integer()->null(),
            "year" => $this->integer()->null(),
            "amount" => $this->double(2)->null(),
            "comment" => $this->text()->null(),
            "created_at" => $this->integer(),
            "updated_at" => $this->integer()
        ]);

        $this->createTable('{{%user_salary_payment}}', [
            'id' => $this->primaryKey(),
            "user_id" => $this->integer()->null(),
            "salary_id" => $this->integer()->null(),
            "date" => $this->date()->null(),
            "amount" => $this->double(2)->null(),
            "payment_type" => $this->string()->null(),
            "comment" => $this->text()->null(),
            "created_at" => $this->integer(),
            "updated_at" => $this->integer()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_revenue}}');
    }
}
