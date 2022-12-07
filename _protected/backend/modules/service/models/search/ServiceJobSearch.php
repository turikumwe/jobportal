<?php

namespace backend\modules\service\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceJob;

/**
 * ServiceJobSearch represents the model behind the search form about `common\models\ServiceJob`.
 */
class ServiceJobSearch extends ServiceJob
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'positions_number', 'economic_sector_id', 'education_level_id', 'education_field_id', 'action_id', 'district_id', 'posted', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['employer', 'jobtitle', 'job_summary', 'job_responsability', 'job_skill_requirement', 'job_remuneration', 'posting_date', 'closure_date', 'how_to_apply', 'contact_phone', 'contact_email', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
            $query = ServiceJob::find();
        }else{
            $query = ServiceJob::find()->deleted();
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
            'posting_date' => $this->posting_date,
            'closure_date' => $this->closure_date,
            'action_id' => $this->action_id,
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
            ->andFilterWhere(['like', 'jobtitle', $this->jobtitle])
            ->andFilterWhere(['like', 'job_summary', $this->job_summary])
            ->andFilterWhere(['like', 'job_responsability', $this->job_responsability])
            ->andFilterWhere(['like', 'job_skill_requirement', $this->job_skill_requirement])
            ->andFilterWhere(['like', 'job_remuneration', $this->job_remuneration])
            ->andFilterWhere(['like', 'how_to_apply', $this->how_to_apply])
            ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
            ->andFilterWhere(['like', 'contact_email', $this->contact_email]);

        return $dataProvider;
    }
}
