<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SIsco08Level3;

/**
 * SIsco08Level3Search represents the model behind the search form about `backend\models\SIsco08Level3`.
 */
class SIsco08Level3Search extends SIsco08Level3
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level2_id'], 'integer'],
            [['code', 'cat3_description'], 'safe'],
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
        $query = SIsco08Level3::find();

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
            ->andFilterWhere(['like', 'cat3_description', $this->cat3_description]);

        return $dataProvider;
    }
}
