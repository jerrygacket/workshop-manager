<?php

use yii\db\Migration;

/**
 * Class m200417_074302_add_field_task_logger_table
 */
class m200417_074302_add_field_task_logger_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task_logger','techCardTitle', 'string');
        $this->addColumn('task_logger','techCardNumber', 'string');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task_logger','techCardTitle');
        $this->dropColumn('task_logger','techCardNumber');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200417_074302_add_field_task_logger_table cannot be reverted.\n";

        return false;
    }
    */
}
