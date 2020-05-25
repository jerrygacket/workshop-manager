<?php


namespace app\models;

use yii\httpclient\Client;
use yii\httpclient\Response;

class YellowERPClient
{
    const TABLES = [
        'clients' => 'Catalog_Контрагенты',
        'partners' => 'Catalog_Партнеры',
        'managers' => 'Catalog_Пользователи',
        'orgs' => 'Catalog_Организации',
        'departments' => 'Catalog_СтруктураПредприятия',
        'adChannels' => 'ChartOfCharacteristicTypes_КаналыРекламныхВоздействий',
        'leadChannels' => 'InformationRegister_ИсточникиПервичногоИнтереса',
        'shipments' => 'Document_РеализацияТоваровУслуг',
        'cashlessPayments' => 'Document_ПоступлениеБезналичныхДенежныхСредств',
        'cashPayments' => 'Document_ПриходныйКассовыйОрдер',
        'debtPayments' => 'Document_ВзаимозачетЗадолженности',
        'creditPayments' => 'Document_СписаниеЗадолженности',
        'cardPayments' => 'Document_ОперацияПоПлатежнойКарте',
        'goodNames' => 'Catalog_Номенклатура',
        'goodChars' => 'Catalog_ХарактеристикиНоменклатуры',
        'rawMaterials' => 'Catalog_ХарактеристикиНоменклатуры',
        'prices' => 'InformationRegister_ЦеныНоменклатуры',
        'priceTypes' => 'Catalog_ВидыЦен',
        'orders' => 'Document_ЗаказКлиента',
        'techCards' => 'Document__ТехнологическаяКарта',
        'agreements' => 'Catalog_СоглашенияСКлиентами',
        'operations' => 'Catalog__ТехнологическиеОперации',
    ];

    const UT_SERVER = 'http://yellowServer.com';
    const UT_BASE = 'yellowbase';
    const UT_PASS = 'passwrd';
    const UT_USER = 'user';

    private static $instance;

    /**
     * @var $client1C Client
     */
    private $client1C;
    private $authHeader;

    /**
     * gets the instance via lazy initialization (created on first usage)
     */
    public static function getInstance(): YellowERPClient
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */
    private function __construct()
    {
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    private function __wakeup()
    {
    }

    private function connect() {
        $baseUri = [
            self::UT_SERVER,
            self::UT_BASE,
            'odata',
            'standard.odata'
        ];
        $this->client1C = new Client([
            'baseUrl' => implode('/', $baseUri) . '/',
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);
        $this->authHeader = base64_encode(self::UT_USER . ':' . self::UT_PASS);
    }

    /**
     * @param $fromtable
     * @param string $select
     * @param string $where
     * @var $response Response
     * @return array|mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    private function get1cData ($fromtable, $select = '', $where = '') {
        if (empty($this->client1C)) {
            $this->connect();
        }

        $requesturl = $fromtable.'?';
        if (!empty($where)) {
            $requesturl .= '$filter='.str_replace(' ', '%20', $where).'&';
        }
        if (!empty($select)) {
            $requesturl .= '$select='.$select.'&';
        }
        $requesturl .= '$format=json;odata=nometadata';

        $response = $this->client1C->createRequest()
            ->addHeaders(['Authorization' => 'Basic '.$this->authHeader])
            ->setOptions([
                'timeout' => 500,
            ])
            ->setMethod('GET')
            ->setUrl($requesturl)
            ->send();


        if ($response->isOk) {
            return $response->data['value'] ?? [] ;
        }

        return $requesturl;
    }

    public function getTable($tableName, $select = '', $where = '', $key = 'Ref_Key') {
//        if (substr_count($select,'Ref_Key') === 0) {
//            $select = mb_strlen($select) > 0 ? ',Ref_Key' : 'Ref_Key';
//        }
        //$keys = explode(',', $select);
        $data = $this->get1cData($tableName, $select, $where);
        $result = [];
        if (is_array($data)) {
            foreach ($data as $row) {
                $result[$row[$key]] = $row;
            }
        }
        return $result;
    }

    public function getRawData(array $tables) {
        $result = [];
        $select = $refKey = 'Ref_Key';
        $where = '';
        foreach ($tables as $key => $table) {
            if (is_array($table)) {
                $tableName = $key;
                $select = $table['select'] ?? $select;
                $where = $table['where'] ?? '';
                $refKey = $table['refKey'] ?? 'Ref_Key';
            } else {
                $tableName = $table;
            }
            $result[$tableName] = $this->getTable(
                self::TABLES[$tableName],
                $select,
                $where,
                $refKey
            );
        }

        return $result;
    }
}