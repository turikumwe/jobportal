<?php

namespace frontend\modules\employer\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmplEmployer;

/**
 * EmplEmployerSearch represents the model behind the search form about `common\models\EmplEmployer`.
 */
class EmplEmployerSearch extends EmplEmployer {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'parent', 'child', 'employer_type_id', 'registration_authority_id', 'ownership_id', 'district_id', 'created_by', 'deleted_by', 'empl_economic_sector', 'updated_by'], 'integer'],
            [['company_name', 'registration_start', 'registration_end', 'district_id', 'empl_phone_number', 'empl_email', 'company_name_abbraviatio', 'avatar_path', 'avatar_base_url', 'opening_date', 'tin', 'empl_economic_sector', 'show_address', 'show_economic_sector', 'show_employer_status', 'show_reference', 'show_employer_summary', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = EmplEmployer::find();

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
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'ownership_id' => $this->ownership_id,
            'opening_date' => $this->opening_date,
            'employer_type_id' => $this->employer_type_id,
            'registration_authority_id' => $this->registration_authority_id,
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
                ->andFilterWhere(['between', 'empl_employer.created_at', $this->registration_start, $this->registration_end])
                ->andFilterWhere(['like', 'show_employer_summary', $this->show_employer_summary]);

        return $dataProvider->query->all();
    }

    public function searchAdmin($params) {
        $query = EmplEmployer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // $query->JoinWith('emplAddress');
        // $query->JoinWith('economicSector');

        $query->LeftJoin('empl_address', 'empl_employer.id=empl_address.employer_id');
        $query->LeftJoin('empl_economic_sector', 'empl_employer.id=empl_economic_sector.employer_id');

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
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'ownership_id' => $this->ownership_id,
            'opening_date' => $this->opening_date,
            'employer_type_id' => $this->employer_type_id,
            'empl_address.district_id' => $this->district_id,
            'empl_address.email_address' => $this->empl_email,
            'empl_address.phone_number' => $this->empl_phone_number,
            'registration_authority_id' => $this->registration_authority_id,
            'empl_economic_sector.economic_sector_id' => $this->empl_economic_sector,
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
                ->andFilterWhere(['between', 'empl_employer.created_at', $this->registration_start, $this->registration_end])
                ->andFilterWhere(['like', 'show_employer_summary', $this->show_employer_summary]);

        return $dataProvider;
    }

    public function searchReport($params) {
        $query = EmplEmployer::find()->select(
                        [
                            'empl_employer.id,
                economic_sector_id,
                main_economic_sector_id,
                district_id,
                COUNT(empl_employer.id) AS stat'
                        ])
                ->orderBy([
                    'economic_sector_id' => SORT_ASC,
                    'main_economic_sector_id' => SORT_ASC,
                    'district_id' => SORT_ASC
                ])
                ->groupBy(['economic_sector_id', 'district_id', 'main_economic_sector_id', 'empl_employer.id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->JoinWith('emplAddress');
        $query->JoinWith('economicSector');

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
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'ownership_id' => $this->ownership_id,
            'opening_date' => $this->opening_date,
            'employer_type_id' => $this->employer_type_id,
            'empl_address.district_id' => $this->district_id,
            'empl_address.email_address' => $this->empl_email,
            'empl_address.phone_number' => $this->empl_phone_number,
            'registration_authority_id' => $this->registration_authority_id,
            'empl_economic_sector.economic_sector_id' => $this->empl_economic_sector,
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
                ->andFilterWhere(['between', 'empl_employer.created_at', $this->registration_start, $this->registration_end])
                ->andFilterWhere(['like', 'show_employer_summary', $this->show_employer_summary]);

        return $dataProvider;
    }

    public function searchEmployersbydistrict($params, $district) {
        $query = EmplEmployer::find()->andWhere(['empl_address.district_id' => $district]);
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // $query->JoinWith('emplAddress');
        // $query->JoinWith('economicSector');

        $query->LeftJoin('empl_address', 'empl_employer.id=empl_address.employer_id');
        $query->LeftJoin('empl_economic_sector', 'empl_employer.id=empl_economic_sector.employer_id');

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
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'ownership_id' => $this->ownership_id,
            'opening_date' => $this->opening_date,
            'employer_type_id' => $this->employer_type_id,
            'empl_address.district_id' => $this->district_id,
            'empl_address.email_address' => $this->empl_email,
            'empl_address.phone_number' => $this->empl_phone_number,
            'registration_authority_id' => $this->registration_authority_id,
            'empl_economic_sector.economic_sector_id' => $this->empl_economic_sector,
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
                 ->andFilterWhere(['between', 'empl_employer.created_at', $this->registration_start, $this->registration_end])
              
                ->andFilterWhere(['like', 'show_employer_summary', $this->show_employer_summary]);

        return $dataProvider;
    }

}
