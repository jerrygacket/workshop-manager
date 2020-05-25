<?php

use yii\db\Migration;

/**
 * Class m200422_105235_add_field_orderNumber_task_logger_table
 */
class m200422_105235_add_field_orderNumber_task_logger_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task_logger','orderNumber', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task_logger','orderNumber');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200422_105235_add_field_orderNumber_task_logger_table cannot be reverted.\n";

        return false;
    }
    */
}
