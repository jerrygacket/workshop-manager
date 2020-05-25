<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "user_operations".
 *
 * @property int $id
 * @property int|null $userId
 * @property string|null $techCardUuid
 * @property string|null $operationUuid
 * @property int|null $total
 * @property int|null $done
 * @property string|null $description
 * @property string $created_on
 * @property string $updated_on
 * @property string|null $orderNumber
 *
 * @property TaskLogger[] $taskLoggers
 */
class UserOperations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_operations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'total', 'done'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['techCardUuid', 'operationUuid'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 256],
            [['orderNumber'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userId' => Yii::t('app', 'User ID'),
            'techCardUuid' => Yii::t('app', 'Tech Card Uuid'),
            'operationUuid' => Yii::t('app', 'Operation Uuid'),
            'total' => Yii::t('app', 'Total'),
            'done' => Yii::t('app', 'Done'),
            'description' => Yii::t('app', 'Description'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'orderNumber' => Yii::t('app', 'Order Number'),
        ];
    }

    /**
     * Gets query for [[TaskLoggers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskLoggers()
    {
        return $this->hasMany(TaskLogger::className(), ['operationId' => 'id']);
    }
}
