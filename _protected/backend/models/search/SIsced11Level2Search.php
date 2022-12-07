<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SIsced11Level2;

/**
 * SIsced11Level2Search represents the model behind the search form about `backend\models\SIsced11Level2`.
 */
class SIsced11Level2Search extends SIsced11Level2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level1_id'], 'integer'],
            [['code', 'subcategory_cat2'], 'safe'],
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
        $query = SIsced11Level2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'level1_id' => $this->level1_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'subcategory_cat2', $this->subcategory_cat2]);

        return $dataProvider;
    }
}
