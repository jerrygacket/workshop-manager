<?php

use yii\db\Migration;

/**
 * Class m200422_092920_add_field_user_operations_table
 */
class m200422_092920_add_field_user_operations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_operations','orderNumber', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_operations','orderNumber');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200422_092920_add_field_user_operations_table cannot be reverted.\n";

        return false;
    }
    */
}
