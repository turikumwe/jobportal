<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SDistrict;

/**
 * SDistrictSearch represents the model behind the search form about `backend\models\SDistrict`.
 */
class SDistrictSearch extends SDistrict
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'province_id'], 'integer'],
            [['district'], 'safe'],
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
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SDistrict::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'province_id' => $this->province_id,
        ]);

        $query->andFilterWhere(['like', 'district', $this->district]);

        return $dataProvider;
    }
}
