<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SIsco08Level2;

/**
 * SIsco08Level2Search represents the model behind the search form about `backend\models\SIsco08Level2`.
 */
class SIsco08Level2Search extends SIsco08Level2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level1_id'], 'integer'],
            [['code', 'cat2_description'], 'safe'],
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
        $query = SIsco08Level2::find();

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
            ->andFilterWhere(['like', 'cat2_description', $this->cat2_description]);

        return $dataProvider;
    }
}
