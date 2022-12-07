<?php

namespace backend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JsEducation;

/**
 * JsEducationSearch represents the model behind the search form about `common\models\JsEducation`.
 */
class JsEducationSearch extends JsEducation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'country_id', 'education_level_id', 'education_field_id', 'grade_id', 'certificate_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['school', 'exact_quali', 'start_date', 'end_date', 'certificate_path', 'certificate_base_url', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
            $query = JsEducation::find();
        }else{
            $query = JsEducation::find()->deleted();
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
            'country_id' => $this->country_id,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'grade_id' => $this->grade_id,
            'certificate_id' => $this->certificate_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'school', $this->school])
            ->andFilterWhere(['like', 'exact_quali', $this->exact_quali])
            ->andFilterWhere(['like', 'certificate_path', $this->certificate_path])
            ->andFilterWhere(['like', 'certificate_base_url', $this->certificate_base_url]);

        return $dataProvider;
    }
}
