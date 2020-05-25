<?php


namespace app\models;


use app\models\base\UserOperations;
use yii\data\ActiveDataProvider;

class TaskLoggerSearch extends TaskLogger
{
    public $operation;
    public $user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'operationId', 'total', 'done', 'totalDone'], 'integer'],
            [['created_on','techCardUuid', 'operationUuid','techCardTitle', 'techCardNumber','operationId'], 'safe'],
        ];
    }



}