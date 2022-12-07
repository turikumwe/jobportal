<?php

namespace frontend\modules\jobseeker\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserProfile;
use common\models\JsAddress;

/**
 * UserProfileSearch represents the model behind the search form about `common\models\UserProfile`.
 */
class UserProfileSearch extends UserProfile {

    public $number;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'gender', 'document_type', 'nationality', 'marital_status', 'disabled', 'disability_id', 'education_level_id', 'education_field_id', 'district_id', 'iscolevel1_id', 'iscolevel2_id', 'iscolevel3_id', 'occupation_id'], 'integer'],
            [['firstname', 'middlename', 'lastname', 'avatar_path', 'avatar_base_url', 'locale', 'id_number', 'passport_number', 'dob', 'phone_number', 'terminate', 'show_education', 'show_experience', 'show_profile_summary', 'show_contact', 'show_skill', 'show_endorsement', 'show_recommendation', 'show_training', 'show_language', 'email', 'education_level_id', 'education_field_id', 'district_id', 'created_at', 'iscolevel1_id,iscolevel2_id,iscolevel3_id,occupation_id', 'registration_start', 'registration_end', 'mediator_id', 'province_id', 'graduation_date', 'country_id'], 'safe'],
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
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'document_type' => $this->document_type,
            'dob' => $this->dob,
            'nationality' => $this->nationality,
            'marital_status' => $this->marital_status,
            'disabled' => $this->disabled,
            'disability_id' => $this->disability_id,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'graduation_date' => $this->graduation_date,
            'js_address.district_id' => $this->district_id,
            's_district.province_id' => $this->province_id,
            's_district.mediator_id' => $this->mediator_id,
            //'iscolevel1_id'          => $this->iscolevel1_id,
            //'iscolevel2_id'          => $this->iscolevel2_id,
            //'iscolevel3_id'          => $this->iscolevel3_id,
            'occupation_id' => $this->occupation_id,
            'js_address.country_id' => 183
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

        // if(isset($this->numberEducation) && $this->numberEducation > 0){
        //     $query->having(['>', 'count(user_profile.user_id)' , (int)$this->numberEducation]) ;
        // }


        return $dataProvider;
    }

    public function searchProfiles() {
        $query = UserProfile::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function searchAbroad($params) {
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
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'document_type' => $this->document_type,
            'dob' => $this->dob,
            'nationality' => $this->nationality,
            'marital_status' => $this->marital_status,
            'disabled' => $this->disabled,
            'disability_id' => $this->disability_id,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'js_address.district_id' => $this->district_id,
            //'iscolevel1_id'          => $this->iscolevel1_id,
            //'iscolevel2_id'          => $this->iscolevel2_id,
            //'iscolevel3_id'          => $this->iscolevel3_id,
            'occupation_id' => $this->occupation_id
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
                ->andFilterWhere(['like', 'show_language', $this->show_language])
                ->andFilterWhere(['!=', 'js_address.country_id', 183]);

        return $dataProvider;
    }

    public function searchReport($params) {
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
                ->groupBy(['nationality', 'gender', 'disability_id', 'education_level_id', 'occupation_id', 'district_id', 'education_field_id', 'user_profile.user_id']);

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
            'gender' => $this->gender,
            'nationality' => $this->nationality,
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'js_address.district_id' => $this->district_id,
            'occupation_id' => $this->occupation_id
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
                ->andFilterWhere(['between', 'user_profile.created_at', $this->registration_start, $this->registration_end])
                ->andFilterWhere(['like', 'terminate', $this->terminate]);

        return $dataProvider;
    }

    public function searchResidence($params, $status = null) {
        $query = UserProfile::find()->groupBy('user_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        (is_null($status)) ? $query->leftJoin('js_address', 'js_address.user_id=user_profile.user_id') : $query->leftJoin('jsAddress.district');
        $query->leftJoin('js_education', 'js_education.user_id=user_profile.user_id');
        // $query->joinWith('jsExperience');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
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
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'graduation_date' => $this->graduation_date,
            'js_address.district_id' => $this->district_id,
            's_district.province_id' => $this->province_id,
            's_district.mediator_id' => $this->mediator_id,
            //'iscolevel1_id'          => $this->iscolevel1_id,
            //'iscolevel2_id'          => $this->iscolevel2_id,
            //'iscolevel3_id'          => $this->iscolevel3_id,
            'occupation_id' => $this->occupation_id,
            'js_address.country_id' => $this->country_id,
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

        // if(isset($this->numberEducation) && $this->numberEducation > 0){
        //     $query->having(['>', 'count(user_profile.user_id)' , (int)$this->numberEducation]) ;
        // }


        return $dataProvider;
    }

    public function searchJobseekersbydistrict($params, $district) {
        // echo $district;die;
        $query = UserProfile::find()->andWhere(['js_address.district_id' => $district]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('jsAddress');
        // $query->joinWith('jsEducation');
        //$query->joinWith('jsExperience');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
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
            'education_level_id' => $this->education_level_id,
            'education_field_id' => $this->education_field_id,
            'graduation_date' => $this->graduation_date,
            'js_address.district_id' => $this->district_id,
            's_district.province_id' => $this->province_id,
            's_district.mediator_id' => $this->mediator_id,
            //'iscolevel1_id'          => $this->iscolevel1_id,
            //'iscolevel2_id'          => $this->iscolevel2_id,
            //'iscolevel3_id'          => $this->iscolevel3_id,
            'occupation_id' => $this->occupation_id,
                // 'js_address.country_id'     => 183
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

        // if(isset($this->numberEducation) && $this->numberEducation > 0){
        //     $query->having(['>', 'count(user_profile.user_id)' , (int)$this->numberEducation]) ;
        // }


        return $dataProvider;
    }

    public function findServicedByGender($g, $service_id = null, $fo = null, $to = null, $name = null) {

        // echo $district;die;
        //$query = UserProfile::find()->andWhere(['js_address.district_id' => $district]);
        //$query = \common\models\MediatorJobseekerService::find()->where(['service_id1' => $service_id]);
        $searchModel = new UserProfileSearch();
        $serviced_users = $searchModel->searchProfiles(Yii::$app->request->queryParams);
        $serviced_users->query->select('user_profile.*');
        $serviced_users->query->rightJoin('mediator_service_client', 'mediator_service_client.user_id = user_profile.user_id');
        $serviced_users->query->rightJoin('mediator_jobseeker_service', 'mediator_service_client.mediator_jobseeker_service_id = mediator_jobseeker_service.id');
        $serviced_users->query->andWhere(['user_profile.gender' => $g]);
        if (isset($service_id)) {
            $serviced_users->query->andWhere(['mediator_jobseeker_service.service_id' => $service_id]);
        }
        if ((isset($to) && isset($to)) && UserProfileSearch::isValidDate($fo) && UserProfileSearch::isValidDate($to)) {
            $serviced_users->query->andWhere(['between', 'mediator_jobseeker_service.service_date', $fo, $to]);
        }
        if (isset($name)) {
            $serviced_users->query->andWhere(['like', 'concat(user_profile.firstname, user_profile.lastname)', '%' . htmlspecialchars($name) . '%', false]);
        }
        $serviced_users->query->andWhere(['mediator_jobseeker_service.deleted_by' => 0]);
        return $serviced_users;
    }

    public function findServicedByDisability($service_id = null, $fo = null, $to = null, $name = null) {

        $searchModel = new UserProfileSearch();
        $serviced_users = $searchModel->searchProfiles(Yii::$app->request->queryParams);
        $serviced_users->query->select('user_profile.*');
        $serviced_users->query->rightJoin('mediator_service_client', 'mediator_service_client.user_id = user_profile.user_id');
        $serviced_users->query->rightJoin('mediator_jobseeker_service', 'mediator_service_client.mediator_jobseeker_service_id = mediator_jobseeker_service.id');
        $serviced_users->query->andWhere(['!=', 'user_profile.disability_id', 0]);

        if (isset($service_id)) {
            $serviced_users->query->andWhere(['mediator_jobseeker_service.service_id' => $service_id]);
        }
        if ((isset($to) && isset($to)) && UserProfileSearch::isValidDate($fo) && UserProfileSearch::isValidDate($to)) {
            $serviced_users->query->andWhere(['between', 'mediator_jobseeker_service.service_date', $fo, $to]);
        }
        if (isset($name)) {
            $serviced_users->query->andWhere(['like', 'concat(user_profile.firstname, user_profile.lastname)', '%' . htmlspecialchars($name) . '%', false]);
        }
        $serviced_users->query->andWhere(['mediator_jobseeker_service.deleted_by' => 0]);
        return $serviced_users;
    }

    function isValidDate($date) {
        $tempDate = explode('-', $date);
        if (count($tempDate) === 3) {
            return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
        }
        return false;
    }

}
