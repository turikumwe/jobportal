<?php

namespace frontend\models\search;

use common\models\Tvet;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use yii\httpclient\Client;
use yii\helpers\Json;

/**
 * ArticleSearch represents the model behind the search form about `common\models\Article`.
 */
class TvetSearch extends Tvet
{
    private $_filtered = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'id',
                'qualification_title',
                'school_name',
                'school_acronym',
                'province',
                'district',
                'accreditation_status',
                'school_type',
                'school_activity',
                'school_status',
                'phone',
                'email'
            ], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */

    public function search($params)
    {
        $client = new Client();

        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://mis.rp.ac.rw/api/schools/alldata')
            ->setHeaders(['content-type' => 'application/json'])
            // ->setData([
            //     'sort' => 'qualification_title',
            // ])
            ->send();

        //Convert json to array
        $data = Json::decode($response->content);

        //Reduce the dimensions of a multidimensional array
        // $data = $data['schools'];

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data['schools'],
            // 'allModels' => $this->getData($params),
            'sort' => [
                // 'defaultOrder' => 'qualification_title',
                'attributes' => [
                    'id',
                    'qualification_title',
                    'school_name',
                    'province',
                    'district',
                    'school_type',
                    'school_status',
                ],
            ],
            'pagination' => ['pageSize' => 20],
        ]);

        return $dataProvider;
    }

    // protected function getData($value)
    // {
    //     $client = new Client();

    //     $response = $client->createRequest()
    //         ->setMethod('GET')
    //         ->setUrl('https://mis.rp.ac.rw/api/schools/alldata')
    //         ->setHeaders(['content-type' => 'application/json'])
    //         ->setData([
    //             'sort' => 'qualification_title',
    //         ])
    //         ->send();

    //     $data = Json::decode($response->content);

    //     foreach ($data as $data) {
    //         $data = $data;
    //     }

    //     // if ($this->_filtered) {
    //     //     $data = array_filter($data, function ($value) {
    //     //         $conditions = [true];

    //     //         if (!empty($this->qualification_title)) {
    //     //             $conditions[] = strpos($value['qualification_title'],$this->qualification_title) !== false;
    //     //         }

    //     //         if (!empty($this->school_name)) {
    //     //             $conditions[] = strpos($value['school_name'], $this->school_name) !== false;
    //     //         }

    //     //         if (!empty($this->province)) {
    //     //             $conditions[] = strpos($value['province'], $this->province) !== false;
    //     //         }

    //     //         if (!empty($this->district)) {
    //     //             $conditions[] = strpos($value['district'], $this->district) !== false;
    //     //         }

    //     //         if (!empty($this->school_type)) {
    //     //             $conditions[] = strpos($value['school_type'], $this->school_type) !== false;
    //     //         }

    //     //         if (!empty($this->school_status)) {
    //     //             $conditions[] = strpos($value['school_status'], $this->school_status) !== false;
    //     //         }

    //     //         return array_product($conditions);
    //     //     });
    //     // }

    //     return $data;
    // }
}
