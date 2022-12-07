<?php

namespace backend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JsTraining;

/**
 * JsTrainingSearch represents the model behind the search form about `common\models\JsTraining`.
 */
class JsTrainingSearch extends JsTraining
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['training_center', 'training_title', 'start_date', 'end_date', 'certificate_path', 'certificate_base_url', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
            $query = JsTraining::find();
        }else{
            $query = JsTraining::find()->deleted();
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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'training_center', $this->training_center])
            ->andFilterWhere(['like', 'training_title', $this->training_title])
            ->andFilterWhere(['like', 'certificate_path', $this->certificate_path])
            ->andFilterWhere(['like', 'certificate_base_url', $this->certificate_base_url]);

        return $dataProvider;
    }
}
