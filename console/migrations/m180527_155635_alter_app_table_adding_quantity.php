<?php

use yii\db\Migration;

/**
 * Class m180527_155635_alter_app_table_adding_quantity
 */
class m180527_155635_alter_app_table_adding_quantity extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('applications', 'quantity', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('applications', 'quantity');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180527_155635_alter_app_table_adding_quantity cannot be reverted.\n";

        return false;
    }
    */
}
