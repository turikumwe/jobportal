<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SIsicr4Level3;

/**
 * SIsicr4Level3Search represents the model behind the search form about `backend\models\SIsicr4Level3`.
 */
class SIsicr4Level3Search extends SIsicr4Level3
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level2_id'], 'integer'],
            [['code', 'isic_group_descr'], 'safe'],
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
        $query = SIsicr4Level3::find();

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
            ->andFilterWhere(['like', 'isic_group_descr', $this->isic_group_descr]);

        return $dataProvider;
    }
}
