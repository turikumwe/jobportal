<?php

namespace backend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JsApprenticeshipApplication;

/**
 * JsApprenticeshipApplicationSearch represents the model behind the search form about `common\models\JsApprenticeshipApplication`.
 */
class JsApprenticeshipApplicationSearch extends JsApprenticeshipApplication
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'apprenticeship_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['motivation', 'application_date', 'status_id', 'reason_rejection', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
            $query = JsApprenticeshipApplication::find();
        }else{
            $query = JsApprenticeshipApplication::find()->deleted();
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
            'apprenticeship_id' => $this->apprenticeship_id,
            'application_date' => $this->application_date,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'motivation', $this->motivation])
            ->andFilterWhere(['like', 'status_id', $this->status_id])
            ->andFilterWhere(['like', 'reason_rejection', $this->reason_rejection]);

        return $dataProvider;
    }
}
