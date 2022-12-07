<?php

namespace backend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserProfile;

/**
 * UserProfileSearch represents the model behind the search form about `common\models\UserProfile`.
 */
class UserProfileSearch extends UserProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gender', 'document_type', 'nationality', 'marital_status', 'disabled', 'disability_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['firstname', 'middlename', 'lastname', 'avatar_path', 'avatar_base_url', 'locale', 'id_number', 'passport_number', 'dob', 'phone_number', 'terminate', 'show_education', 'show_experience', 'show_profile_summary', 'show_contact', 'show_skill', 'show_endorsement', 'show_recommendation', 'show_training', 'show_language', 'created_at', 'deleted_at', 'updated_at'], 'safe'],
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
        $query = UserProfile::find();

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
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'document_type' => $this->document_type,
            'dob' => $this->dob,
            'nationality' => $this->nationality,
            'marital_status' => $this->marital_status,
            'disabled' => $this->disabled,
            'disability_id' => $this->disability_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'avatar_path', $this->avatar_path])
            ->andFilterWhere(['like', 'avatar_base_url', $this->avatar_base_url])
            ->andFilterWhere(['like', 'locale', $this->locale])
            ->andFilterWhere(['like', 'id_number', $this->id_number])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'terminate', $this->terminate])
            ->andFilterWhere(['like', 'show_education', $this->show_education])
            ->andFilterWhere(['like', 'show_experience', $this->show_experience])
            ->andFilterWhere(['like', 'show_profile_summary', $this->show_profile_summary])
            ->andFilterWhere(['like', 'show_contact', $this->show_contact])
            ->andFilterWhere(['like', 'show_skill', $this->show_skill])
            ->andFilterWhere(['like', 'show_endorsement', $this->show_endorsement])
            ->andFilterWhere(['like', 'show_recommendation', $this->show_recommendation])
            ->andFilterWhere(['like', 'show_training', $this->show_training])
            ->andFilterWhere(['like', 'show_language', $this->show_language]);

        return $dataProvider;
    }
}
