<?php


namespace app\models;


use Yii;
use yii\base\Model;

class ReportModel extends Model
{
    public $userId;
    public $order;
    public $techCard;
    public $dateFrom;
    public $dateTo;

    public function rules()
    {
        return [
            [['userId'], 'integer'],
            [['dateFrom', 'dateTo'], 'safe'],
            [['order', 'techCard'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => Yii::t('app', 'User'),
            'order' => Yii::t('app', 'Order Number'),
            'techCard' => Yii::t('app', 'Tech Card'),
            'dateFrom' => Yii::t('app', 'Date From'),
            'dateTo' => Yii::t('app', 'Date To'),
        ];
    }

    /**
     * @param null|\DateTime $dateStart
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getReport($dateStart = null, $dateStop = null) {
        $query = TaskLogger::find();

        $query
            ->filterWhere([
            'userId' => $this->userId,
//            'orderNumber' => $this->order,
//            'techCardNumber' => $this->techCard,
            ])
            ->andFilterWhere(['like', 'techCardNumber', $this->techCard])
            ->andFilterWhere(['like', 'orderNumber', $this->order])
            ->andFilterWhere(['>=', 'created_on', $this->dateFrom])
            ->andFilterWhere(['<=', 'created_on', $this->dateTo]);
        if ($dateStart) {
            $query->andwhere(['>=', 'created_on', $dateStart->format('Y-m-d')]);
        }
        if ($dateStop) {
            $query->andwhere(['<', 'created_on', $dateStop->format('Y-m-d')]);
        }

        return $query->all();
    }

    /**
     * @param TaskLogger[] $data
     */
    public function getTotal($data)
    {
        $result['operations'] = [];
        foreach ($data as $item) {
            $operation = $item->getOperation();
            //$result['operations'][] = $operation;
            if (!array_key_exists($operation, $result['operations'])) {
                $result['operations'][$operation]['total'] = 0;
                $result['operations'][$operation]['done'] = 0;
            }
            $result['operations'][$operation]['total'] += $item->total;
            $result['operations'][$operation]['done'] += $item->done;
        }

        return $result;
    }

    public function getDayReport()
    {
        $dayBegin = new \DateTime('today midnight');
        return $this->getReport($dayBegin);
    }

    public function getYesterdayReport()
    {
        $dayBegin = new \DateTime('yesterday midnight');
        $dayEnd = new \DateTime('today midnight');
        return $this->getReport($dayBegin, $dayEnd);
    }

    public function getWeekReport()
    {
        $weekBegin = new \DateTime('this week midnight');
        return $this->getReport($weekBegin);
    }

    public function getMonthReport()
    {
        $monthBegin = new \DateTime('first day of this month midnight');
        return $this->getReport($monthBegin);
    }

    /**
     * @param $data TaskLogger[]
     */
    public static function groupByUser($data) {
        $result = [];
        foreach ($data as $item) {
            $result[$item->userId][] = $item;
        }

        return $result;
    }
}