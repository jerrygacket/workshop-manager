<?php


namespace app\models;


use yii\httpclient\Client;

class KanboardClient
{
    public static function getData($apiProcedure, $params = []) {
        $authHeader = base64_encode('jsonrpc:2171b8444b834345397959fe85eb39992273e0ba3d1da103f84a4c32f54c');

        $client = new Client([
            'baseUrl' => 'http://kanboard.rrr',
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);

        $response = $client->createRequest()
            ->addHeaders(['content-type' => 'application/json'])
            ->addHeaders(['Authorization' => 'Basic '.$authHeader])
            ->setMethod('POST')
            ->setUrl('jsonrpc.php')
            ->setData([
                'jsonrpc' => '2.0',
                'method' => $apiProcedure,
                'id' => '1',
                'params' => $params
            ])
            ->send();

        if ($response->isOk) {
            return $response->data['result'] ?? [] ;
        }

        return [];
    }
}