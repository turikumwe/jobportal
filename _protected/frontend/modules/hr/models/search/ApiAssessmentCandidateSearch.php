<?php

namespace frontend\modules\hr\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\ApiAssessmentCandidate;

/**
 * ApiAssessmentCandidateSearch represents the model behind the search form of `app\models\ApiAssessmentCandidate`.
 */
class ApiAssessmentCandidateSearch extends ApiAssessmentCandidate {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['candidate_id'], 'required'],
            [['candidate_id', 'assessment_id'], 'integer'],
            [['email', 'first_name', 'last_name', 'invitation_uuid', 'created', 'testtaker_id', 'status', 'average', 'is_with_feedback_about_hired', 'reminder_sent', 'last_reminder_sent', 'content_type_name', 'is_hired', 'personality', 'personality_algorithm', 'greenhouse_profile_url', 'stage', 'status_notification','minimum_score','maximum_score'], 'safe'],
            [['candidate_id'], 'unique'],
            [['assessment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiAssessment::class, 'targetAttribute' => ['assessment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ApiAssessmentCandidate::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => 'ID',
            'candidate_id' => 'Candidate ID',
            'assessment_id' => 'Assessment ID',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'invitation_uuid' => 'Invitation Uuid',
            'created' => 'Created',
            'testtaker_id' => 'Testtaker ID',
            'status' => 'Status',
            'average' => 'Average',
            'is_with_feedback_about_hired' => 'Is With Feedback About Hired',
            'reminder_sent' => 'Reminder Sent',
            'last_reminder_sent' => 'Last Reminder Sent',
            'content_type_name' => 'Content Type Name',
            'is_hired' => 'Is Hired',
            'personality' => 'Personality',
            'personality_algorithm' => 'Personality Algorithm',
            'greenhouse_profile_url' => 'Greenhouse Profile Url',
            'stage' => 'Stage',
            'status_notification' => 'Status Notification',
        ]);
        
        $query->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'invitation_uuid', $this->invitation_uuid])
                ->andFilterWhere(['like', 'created', $this->created])
                ->andFilterWhere(['like', 'testtaker_id', $this->testtaker_id])
                ->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'average', $this->average])
                ->andFilterWhere(['like', 'is_with_feedback_about_hired', $this->is_with_feedback_about_hired])
                ->andFilterWhere(['like', 'reminder_sent', $this->reminder_sent])
                ->andFilterWhere(['like', 'last_reminder_sent', $this->last_reminder_sent])
                ->andFilterWhere(['like', 'content_type_name', $this->content_type_name])
                ->andFilterWhere(['like', 'is_hired', $this->is_hired])
                ->andFilterWhere(['like', 'personality', $this->personality])
                ->andFilterWhere(['like', 'personality_algorithm', $this->personality_algorithm])
                ->andFilterWhere(['like', 'greenhouse_profile_url', $this->greenhouse_profile_url])
                ->andFilterWhere(['like', 'stage', $this->stage])
                ->andFilterWhere(['between', 'api_assessment_candidate.average', $this->minimum_score, $this->maximum_score])
                ->andFilterWhere(['like', 'status_notification', $this->status_notification]);

        return $dataProvider;
    }

}
