<?php

namespace backend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JsRecommendation;

/**
 * JsRecommendationSearch represents the model behind the search form about `common\models\JsRecommendation`.
 */
class JsRecommendationSearch extends JsRecommendation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'who_recommended_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['recommendation', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
    public function search($params, $restore=null)
    {
        if(is_null($restore)){
            $query = JsRecommendation::find();
        }else{
            $query = JsRecommendation::find()->deleted();
        }

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
            'who_recommended_id' => $this->who_recommended_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'recommendation', $this->recommendation]);

        return $dataProvider;
    }
}
