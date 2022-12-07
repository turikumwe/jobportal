<?php

namespace frontend\modules\jobseeker\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Winner;

/**
 * WinnerSearch represents the model behind the search form about `common\models\Winner`.
 */
class WinnerSearch extends Winner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_by', 'modified_by'], 'integer'],
            [['created_on', 'modified_on'], 'safe'],
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
        $query = Winner::find()->orderBy(['created_on' => SORT_ASC]);

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
            'user_id' => $this->user_id,
            'created_by' => $this->created_by,
            'created_on' => $this->created_on,
            'modified_by' => $this->modified_by,
            'modified_on' => $this->modified_on,
        ]);

        return $dataProvider;
    }
}
