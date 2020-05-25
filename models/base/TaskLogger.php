<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "task_logger".
 *
 * @property int $id
 * @property int|null $userId
 * @property string|null $techCardUuid
 * @property string|null $operationUuid
 * @property int|null $operationId
 * @property int|null $total
 * @property int|null $done
 * @property int|null $totalDone
 * @property string|null $comment
 * @property string $created_on
 * @property string|null $techCardTitle
 * @property string|null $techCardNumber
 * @property string|null $orderNumber
 *
 * @property UserOperations $operation
 */
class TaskLogger extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_logger';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'operationId', 'total', 'done', 'totalDone'], 'integer'],
            [['comment'], 'string'],
            [['created_on'], 'safe'],
            [['techCardUuid', 'operationUuid'], 'string', 'max' => 64],
            [['techCardTitle', 'techCardNumber', 'orderNumber'], 'string', 'max' => 255],
            [['operationId'], 'exist', 'skipOnError' => true, 'targetClass' => UserOperations::className(), 'targetAttribute' => ['operationId' => 'id']],
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
            'operationId' => Yii::t('app', 'Operation ID'),
            'total' => Yii::t('app', 'Total'),
            'done' => Yii::t('app', 'Done'),
            'totalDone' => Yii::t('app', 'Total Done'),
            'comment' => Yii::t('app', 'Comment'),
            'created_on' => Yii::t('app', 'Created On'),
            'techCardTitle' => Yii::t('app', 'Tech Card Title'),
            'techCardNumber' => Yii::t('app', 'Tech Card Number'),
            'orderNumber' => Yii::t('app', 'Order Number'),
        ];
    }

    /**
     * Gets query for [[Operation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(UserOperations::className(), ['id' => 'operationId']);
    }
}
