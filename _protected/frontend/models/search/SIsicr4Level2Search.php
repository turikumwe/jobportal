<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SIsicr4Level2;

/**
 * SIsicr4Level2Search represents the model behind the search form about `backend\models\SIsicr4Level2`.
 */
class SIsicr4Level2Search extends SIsicr4Level2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level1_id'], 'integer'],
            [['isic_sector_letter', 'code', 'isic_sector_descr'], 'safe'],
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
        $query = SIsicr4Level2::find();

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

        $query->andFilterWhere(['like', 'isic_sector_letter', $this->isic_sector_letter])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'isic_sector_descr', $this->isic_sector_descr]);

        return $dataProvider;
    }
}
