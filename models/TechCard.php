<?php


namespace app\models;


use yii\base\Model;
use yii\httpclient\Client;
use yii\httpclient\Response;

class TechCard extends Model
{
    public static $projects = [
        '5',
        '9',
        '12'
    ];

    public function getAllCards($from = 'KB', $withFiles = false) {
        $method = 'getAllCardsFrom'.$from;

        return (method_exists($this, $method) ? $this->$method($withFiles) : []);
    }

    /**
     * @var $response Response
     * @return array
     */
    public function getAllCardsFromKB($withFiles = false) {
        $tasks = [];
        foreach (self::$projects as $projectId) {
            $projectTasks = KanboardClient::getData('getAllTasks', [
                'project_id' => $projectId,
                'status_id' => 1,
            ]);
            if ($withFiles) {
                foreach ($projectTasks as &$task) {
                    $task['files'] = KanboardClient::getData('getAllTaskFiles', [
                        'task_id' => $task['id'],
                    ]);
                }
            }
            $tasks = array_merge($tasks, $projectTasks);
        }

        return $tasks;
    }

    public function getOperations ($techCardUuid) {
        if (!isset($techCardUuid)) {
            return false;
        }

        $operations = UserOperations::find()->where(['techCardUuid' => $techCardUuid,])->all();
        $result = $operations;

        if (empty($operations)) {
            $operations = $this->get1COperations($techCardUuid);
            foreach ($operations as $key => $item) {
                if ($item['ВидОперации'] == 'ПреПресс') {
                    continue;
                }
                $cutAndPack = (substr_count($item['Description'], 'Резка') > 0)
                    || (substr_count($item['Description'], 'Упаковка') > 0);
                $operation = new UserOperations();
                $operation->userId = \Yii::$app->user->id;
                $operation->total = $cutAndPack ? $item['goodsCount'] : $item['Количество'];
                $operation->done = 0;
                $operation->description = $item['Description'];
                $operation->operationUuid = $key;
                $operation->techCardUuid = $techCardUuid;
                $operation->orderNumber = $this->get1COrder($item['orderKey'])['Number'];
                if ($operation->save()) {
                    $result[] = $operation;
                }
            }
        }

        return $result;
    }

    public function get1COperations($techCardUuid) {
        $result = [];
        $client1c = YellowERPClient::getInstance();
        $operations = $client1c->getRawData([
            'techCards' => [
                'select' => 'Ref_Key,ТехнологическиеОперации,Товары,ЗаказКлиента_Key',
                'where' => 'Ref_Key eq guid\''.$techCardUuid.'\'',
            ]
        ])['techCards'][$techCardUuid];

        foreach ($operations['ТехнологическиеОперации'] as $operation) {
            $key = $operation['ТехнологическаяОперация_Key'];
            $result[$key] = array_merge($operation, $client1c->getRawData([
                'operations' => [
                    'select' => 'Ref_Key,Description',
                    'where' => 'Ref_Key eq guid\''.$key.'\'',
                ]
            ])['operations'][$key]);
            $result[$key]['goodsCount'] = $operations['Товары'][0]['Количество'];
            $result[$key]['orderKey'] = $operations['ЗаказКлиента_Key'];
        }

        return $result;
    }

    public static function getTechCardByUuid($uuid)
    {
        $client1c = YellowERPClient::getInstance();
        $techCard = $client1c->getRawData([
            'techCards' => [
                'select' => 'Ref_Key,Number',
                'where' => 'Ref_Key eq guid\''.$uuid.'\'',
            ]
        ])['techCards'][$uuid];

        return $techCard['Number'];
    }

    private function get1COrder($uuid)
    {
        $result = [];
        $client1c = YellowERPClient::getInstance();
        return $client1c->getRawData([
            'orders' => [
                'select' => 'Ref_Key,Number',
                'where' => 'Ref_Key eq guid\''.$uuid.'\'',
            ]
        ])['orders'][$uuid];
    }
}