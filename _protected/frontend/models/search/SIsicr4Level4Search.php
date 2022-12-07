<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SIsicr4Level4;

/**
 * SIsicr4Level4Search represents the model behind the search form about `backend\models\SIsicr4Level4`.
 */
class SIsicr4Level4Search extends SIsicr4Level4
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level3_id'], 'integer'],
            [['code', 'ecosector'], 'safe'],
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
        $query = SIsicr4Level4::find();

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
            'level3_id' => $this->level3_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'ecosector', $this->ecosector]);

        return $dataProvider;
    }
}
