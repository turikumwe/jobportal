<?php

namespace frontend\modules\abroad\models\search;

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
            [['user_id', 'gender', 'document_type', 'nationality', 'marital_status', 'disabled', 'disability_id','education_level_id','education_field_id','district_id','iscolevel1_id','iscolevel2_id','iscolevel3_id','occupation_id'], 'integer'],
            [['firstname', 'middlename', 'lastname', 'avatar_path', 'avatar_base_url', 'locale', 'id_number', 'passport_number', 'dob', 'phone_number', 'terminate', 'show_education', 'show_experience', 'show_profile_summary', 'show_contact', 'show_skill', 'show_endorsement', 'show_recommendation', 'show_training', 'show_language','email','education_level_id','education_field_id','district_id','created_at','iscolevel1_id,iscolevel2_id,iscolevel3_id,occupation_id','registration_start','registration_end'], 'safe'],
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

        $query->joinWith('jsAddress');
        $query->joinWith('jsEducation');
        //$query->joinWith('jsExperience');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id'                => $this->user_id,
            'gender'                 => $this->gender,
            'document_type'          => $this->document_type,
            'dob'                    => $this->dob,
            'nationality'            => $this->nationality,
            'marital_status'         => $this->marital_status,
            'disabled'               => $this->disabled,
            'disability_id'          => $this->disability_id,
            'education_level_id'     => $this->education_level_id,
            'education_field_id'     => $this->education_field_id,
            'js_address.district_id' => $this->district_id,
            //'iscolevel1_id'          => $this->iscolevel1_id,
            //'iscolevel2_id'          => $this->iscolevel2_id,
            //'iscolevel3_id'          => $this->iscolevel3_id,
            'occupation_id'          => $this->occupation_id
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'avatar_path', $this->avatar_path])
            ->andFilterWhere(['like', 'avatar_base_url', $this->avatar_base_url])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'id_number', $this->id_number])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'terminate', $this->terminate])
            ->andFilterWhere(['like', 'show_education', $this->show_education])
            ->andFilterWhere(['like', 'show_experience', $this->show_experience])
            ->andFilterWhere(['like', 'user_profile.created_at', $this->created_at])
            ->andFilterWhere(['like', 'show_profile_summary', $this->show_profile_summary])
            ->andFilterWhere(['like', 'show_contact', $this->show_contact])
            ->andFilterWhere(['like', 'show_skill', $this->show_skill])
            ->andFilterWhere(['like', 'show_endorsement', $this->show_endorsement])
            ->andFilterWhere(['like', 'show_recommendation', $this->show_recommendation])
            ->andFilterWhere(['like', 'show_training', $this->show_training])
            ->andFilterWhere(['between', 'user_profile.created_at', $this->registration_start, $this->registration_end])
            ->andFilterWhere(['like', 'show_language', $this->show_language]);

        return $dataProvider;
    }

    public function searchReport($params)
    {
        $query = UserProfile::find()->select(
            [
                'user_profile.user_id,
                nationality,
                gender,
                education_level_id,
                education_field_id,
                occupation_id,
                district_id,
                disability_id,
                COUNT(user_profile.user_id) AS stat'
            ])
        ->orderBy([
              'nationality' => SORT_ASC,
              'gender' => SORT_ASC,
              'education_field_id' => SORT_ASC,
              'education_level_id' => SORT_ASC,
              'disability_id' => SORT_ASC,
              'occupation_id' => SORT_ASC
            ])
        ->groupBy(['nationality','gender','disability_id','education_level_id','occupation_id','district_id','education_field_id','user_profile.user_id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('jsAddress');
        $query->joinWith('jsEducation');
        $query->joinWith('jsExperience');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gender'                 => $this->gender,
            'nationality'            => $this->nationality,
            'education_level_id'     => $this->education_level_id,
            'education_field_id'     => $this->education_field_id,
            'js_address.district_id' => $this->district_id,
            'occupation_id'          => $this->occupation_id
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['between', 'user_profile.created_at', $this->registration_start, $this->registration_end])
            ->andFilterWhere(['like', 'terminate', $this->terminate]);

        return $dataProvider;
    }
}
