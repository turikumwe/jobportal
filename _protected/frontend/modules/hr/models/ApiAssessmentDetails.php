<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_details".
 *
 * @property int $id
 * @property int $assessment_id
 * @property string|null $name
 * @property string|null $job_role
 * @property string|null $other_job_role
 * @property string|null $owner
 * @property string|null $benchmark
 * @property string|null $benchmark_name
 * @property string|null $invited
 * @property string|null $started
 * @property string|null $finished
 * @property string|null $knocked_out
 * @property string|null $content_type_name
 * @property string|null $status
 * @property string|null $modified
 * @property string|null $is_showing_hiring_feedback_survey
 * @property string|null $is_candidate_hired
 * @property string|null $reason_for_not_fill_hiring_feedback
 * @property string|null $is_highlighted
 * @property string|null $has_culture_fit
 * @property string|null $candidates_source
 * @property string|null $video_id
 * @property string|null $video_at_end
 * @property string|null $use_snapshots
 * @property string|null $date_of_expiry
 * @property string|null $assessment_extra_time
 * @property string|null $pricing_state
 * @property string|null $has_consumed_credit
 * @property string|null $permitted_extra_time_non_native_speakers
 * @property string|null $permitted_extra_time_person_for_other_capacities
 * @property string|null $language
 * @property string|null $template_id
 *
 * @property ApiAssessment $assessment
 */
class ApiAssessmentDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'api_assessment_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'assessment_id'], 'required'],
            [['id', 'assessment_id'], 'integer'],
            [['name', 'job_role', 'other_job_role', 'owner', 'benchmark', 'benchmark_name', 'invited', 'started', 'finished', 'knocked_out', 'content_type_name', 'status', 'modified', 'is_showing_hiring_feedback_survey', 'is_candidate_hired', 'reason_for_not_fill_hiring_feedback', 'is_highlighted', 'has_culture_fit', 'candidates_source', 'video_id', 'video_at_end', 'use_snapshots', 'date_of_expiry', 'assessment_extra_time', 'pricing_state', 'has_consumed_credit', 'permitted_extra_time_non_native_speakers', 'permitted_extra_time_person_for_other_capacities', 'language', 'template_id'], 'safe'],
            [['id'], 'unique'],
            [['assessment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiAssessments::class, 'targetAttribute' => ['assessment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'assessment_id' => 'Assessment ID',
            'name' => 'Name',
            'job_role' => 'Job Role',
            'other_job_role' => 'Other Job Role',
            'owner' => 'Owner',
            'benchmark' => 'Benchmark',
            'benchmark_name' => 'Benchmark Name',
            'invited' => 'Invited',
            'started' => 'Started',
            'finished' => 'Finished',
            'knocked_out' => 'Knocked Out',
            'content_type_name' => 'Content Type Name',
            'status' => 'Status',
            'modified' => 'Modified',
            'is_showing_hiring_feedback_survey' => 'Is Showing Hiring Feedback Survey',
            'is_candidate_hired' => 'Is Candidate Hired',
            'reason_for_not_fill_hiring_feedback' => 'Reason For Not Fill Hiring Feedback',
            'is_highlighted' => 'Is Highlighted',
            'has_culture_fit' => 'Has Culture Fit',
            'candidates_source' => 'Candidates Source',
            'video_id' => 'Video ID',
            'video_at_end' => 'Video At End',
            'use_snapshots' => 'Use Snapshots',
            'date_of_expiry' => 'Date Of Expiry',
            'assessment_extra_time' => 'Assessment Extra Time',
            'pricing_state' => 'Pricing State',
            'has_consumed_credit' => 'Has Consumed Credit',
            'permitted_extra_time_non_native_speakers' => 'Permitted Extra Time Non Native Speakers',
            'permitted_extra_time_person_for_other_capacities' => 'Permitted Extra Time Person For Other Capacities',
            'language' => 'Language',
            'template_id' => 'Template ID',
        ];
    }

    /**
     * Gets query for [[Assessment]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentQuery
     */
    public function getAssessment()
    {
        return $this->hasOne(ApiAssessments::class, ['id' => 'assessment_id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentDetailsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApiAssessmentDetailsQuery(get_called_class());
    }
}
