<?php

namespace frontend\models\search;

use common\models\Article;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use yii\httpclient\Client;
use yii\helpers\Json;

/**
 * ArticleSearch represents the model behind the search form about `common\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['slug', 'title'], 'safe'],
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
        $query = Article::find()->published();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    public function searchTvet($params)
    {
        $client = new Client();

        $query = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://mis.rp.ac.rw/api/schools/alldata')
            ->setHeaders(['content-type' => 'application/json'])
            // ->setData([
            //     'sort' => 'qualification_title',
            // ])
            ->send();

        // $data = Json::decode($response->content);

        // foreach ($data as $data) {
        //     $query = $data;
        // }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
            'defaultOrder' => 'qualification_title',
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

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'qualification_title', $this->qualification_title])
            ->andFilterWhere(['like', 'school_name', $this->school_name])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'school_type', $this->school_type])
            ->andFilterWhere(['like', 'school_status', $this->school_status]);

        return $dataProvider;
    }
}
