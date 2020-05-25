<?php

use yii\db\Migration;

/**
 * Class m200416_112931_create_operation_logger_FK
 */
class m200416_112931_create_operation_logger_FK extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('TaskLogger_operationIdFK',
            '{{%task_logger}}','operationId','user_operations','id',
            'SET NULL','SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('TaskLogger_operationIdFK','{{%task_logger}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200416_112931_create_operation_logger_FK cannot be reverted.\n";

        return false;
    }
    */
}
