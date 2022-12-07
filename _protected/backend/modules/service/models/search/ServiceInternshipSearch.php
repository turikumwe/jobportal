<?php

namespace backend\modules\service\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceInternship;

/**
 * ServiceInternshipSearch represents the model behind the search form about `common\models\ServiceInternship`.
 */
class ServiceInternshipSearch extends ServiceInternship
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'positions_number', 'economic_sector_id', 'education_level_id', 'education_field_id', 'district_id', 'posted', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['employer', 'employer_description', 'internship_name', 'internship_description', 'intern_duties', 'intern_responsability', 'intern_skill_requirement', 'publication_date', 'closure_date', 'how_to_apply', 'contact_phone', 'contact_email', 'any_further_information', 'action_id', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
            $query = ServiceInternship::find();
        }else{
            $query = ServiceInternship::find()->deleted();
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
            'positions_number' => $this->positions_number,
            'economic_sector_id' => $this->economic_sector_id,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'publication_date' => $this->publication_date,
            'closure_date' => $this->closure_date,
            'district_id' => $this->district_id,
            'posted' => $this->posted,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'employer', $this->employer])
            ->andFilterWhere(['like', 'employer_description', $this->employer_description])
            ->andFilterWhere(['like', 'internship_name', $this->internship_name])
            ->andFilterWhere(['like', 'internship_description', $this->internship_description])
            ->andFilterWhere(['like', 'intern_duties', $this->intern_duties])
            ->andFilterWhere(['like', 'intern_responsability', $this->intern_responsability])
            ->andFilterWhere(['like', 'intern_skill_requirement', $this->intern_skill_requirement])
            ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
            ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
            ->andFilterWhere(['like', 'contact_email', $this->contact_email])
            ->andFilterWhere(['like', 'any_further_information', $this->any_further_information])
            ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }
}
