<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_logger}}`.
 */
class m200416_071329_create_task_logger_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_logger}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(11),
            'techCardUuid' => $this->string(64),
            'operationUuid' => $this->string(64),
            'operationId' => $this->integer(11),
            'total' => $this->integer(11),
            'done' => $this->integer(11)->defaultValue(0),
            'totalDone' => $this->integer(11)->defaultValue(0),
            'comment' => $this->text()->defaultValue(''),
            'created_on'=>$this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task_logger}}');
    }
}
