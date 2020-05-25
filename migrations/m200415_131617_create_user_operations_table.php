<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_operations}}`.
 */
class m200415_131617_create_user_operations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_operations}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(11),
            'techCardUuid' => $this->string(64),
            'operationUuid' => $this->string(64),
            'total' => $this->integer(11),
            'done' => $this->integer(11)->defaultValue(0),
            'description' => $this->string(256)->defaultValue(''),
            'created_on'=>$this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_on'=>$this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_operations}}');
    }
}
