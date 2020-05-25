<?php


namespace app\models;

use app\models\base\UserOperations;
use yii\data\ActiveDataProvider;

/**
 * @property User $user
 */
class TaskLogger extends \app\models\base\TaskLogger
{
    public $user;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'operation' => \Yii::t('app', 'Operation'),
            'user' => \Yii::t('app', 'User'),
        ]);
    }

    public function getOperation()
    {
        return $this->hasOne(UserOperations::className(), ['id' => 'operationId'])->one()->description;
    }

    public function getUser()
    {
        return (empty($this->userId)) ? 'No user' : User::findById($this->userId);
    }

    public function search($params) {
        $query = TaskLogger::find();

//        $this->load($params);
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//
//        // grid filtering conditions
        if (isset($params['user'])) {
            $query->andFilterWhere([
                'userId' =>$params['user'],
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'id'=>SORT_DESC
                ]
            ]
        ]);
//
//        $query->andFilterWhere(['like', 'techCardTitle', $this->techCardTitle])
//            ->andFilterWhere(['like', 'techCardNumber', $this->techCardNumber]);

        return $dataProvider;
    }
}