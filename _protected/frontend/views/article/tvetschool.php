<?php

    
    use yii\grid\GridView;
    use yii\httpclient\Client;
    use yii\helpers\Json;
    use yii\data\ArrayDataProvider;

    $request = Yii::$app->request;

    $id = $request->get('id');
    $qual = $request->get('qual');

    $client = new Client();

    $response = $client->createRequest()
        ->setMethod('GET')
        ->setUrl("https://mis.rp.ac.rw/api/schoolsbyqualification/$id")
        ->setHeaders(['content-type' => 'application/json'])
        ->send();

    $data = Json::decode($response->content);

    foreach ($data as $data) {
        $schools = $data;
    }

    $dataProvider = new ArrayDataProvider([
        'allModels' => $schools,
        'sort' => [
            'attributes' => ['province', 'district', 'school_name', 'email', 'manager_phone'],
        ],
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);

    echo '<b>Qualification:</b> '.$qual.'<br><br>';

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // 'id',
            'province',
            'district',
            'school_name',
            'email',
            'manager_phone',
        ],
    ]);
?>