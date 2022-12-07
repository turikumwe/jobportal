<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SIsced11Level3;

/**
 * SIsced11Level3Search represents the model behind the search form about `backend\models\SIsced11Level3`.
 */
class SIsced11Level3Search extends SIsced11Level3
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level2_id'], 'integer'],
            [['code', 'subcategory_cat3'], 'safe'],
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
        $query = SIsced11Level3::find();

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
            'level2_id' => $this->level2_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'subcategory_cat3', $this->subcategory_cat3]);

        return $dataProvider;
    }
}
