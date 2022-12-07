<?php

namespace backend\modules\employer\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmplEmployer;

/**
 * EmplEmployerSearch represents the model behind the search form about `common\models\EmplEmployer`.
 */
class EmplEmployerSearch extends EmplEmployer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'child', 'employer_type_id', 'registration_authority_id', 'ownership_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['company_name', 'company_name_abbraviatio', 'avatar_path', 'avatar_base_url', 'opening_date', 'tin', 'show_address', 'show_economic_sector', 'show_employer_status', 'show_reference', 'show_employer_summary', 'show_manager', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
    // public function search($params)
    // {
    //     $query = EmplEmployer::find();

    public function search($params, $restore=null)
    {
        if(is_null($restore)){
            $query = EmplEmployer::find();
        }else{
            $query = EmplEmployer::find()->deleted();
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
            'parent' => $this->parent,
            'child' => $this->child,
            'employer_type_id' => $this->employer_type_id,
            'opening_date' => $this->opening_date,
            'registration_authority_id' => $this->registration_authority_id,
            'ownership_id' => $this->ownership_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'company_name_abbraviatio', $this->company_name_abbraviatio])
            ->andFilterWhere(['like', 'avatar_path', $this->avatar_path])
            ->andFilterWhere(['like', 'avatar_base_url', $this->avatar_base_url])
            ->andFilterWhere(['like', 'tin', $this->tin])
            ->andFilterWhere(['like', 'show_address', $this->show_address])
            ->andFilterWhere(['like', 'show_economic_sector', $this->show_economic_sector])
            ->andFilterWhere(['like', 'show_employer_status', $this->show_employer_status])
            ->andFilterWhere(['like', 'show_reference', $this->show_reference])
            ->andFilterWhere(['like', 'show_employer_summary', $this->show_employer_summary])
            ->andFilterWhere(['like', 'show_manager', $this->show_manager]);

        return $dataProvider;
    }
}
