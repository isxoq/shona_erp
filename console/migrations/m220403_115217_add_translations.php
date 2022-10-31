<?php

use yii\db\Migration;

/**
 * Class m220403_115217_add_translations
 */
class m220403_115217_add_translations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(file_get_contents(Yii::getAlias("@console/migrations") . '/dump.sql'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220403_115217_add_translations cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220403_115217_add_translations cannot be reverted.\n";

        return false;
    }
    */
}
