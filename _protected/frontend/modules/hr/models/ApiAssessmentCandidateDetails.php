<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_candidate_details".
 *
 * @property int $candidate_id
 * @property int $assessment_id
 * @property int $testtaker_id
 * @property string|null $assessment_name
 * @property string|null $invited
 * @property string|null $status
 * @property string|null $has_consumed_credit
 * @property string|null $content_type_name
 * @property string|null $average
 * @property string|null $test_taker_photos
 * @property string|null $is_exited_full_screen
 * @property string|null $is_left_screen
 * @property string|null $modified
 * @property string|null $last_activity
 * @property string|null $highlight
 * @property string|null $ip
 * @property string|null $repeated_ip
 * @property string|null $geoip
 * @property string|null $role
 * @property string|null $user_agent
 * @property string|null $review
 * @property string|null $stage
 * @property string|null $reminder_sent
 * @property string|null $public_link
 * @property string|null $assessment_benchmark
 * @property string|null $tests_detail
 * @property string|null $anti_cheating_photos_removed
 * @property string|null $is_camera_enabled
 * @property string|null $is_english_native_language
 * @property string|null $accessibility_condition_description
 * @property string|null $accessibility_condition_disclose
 * @property string|null $accessibility_condition_extra_time
 * @property string|null $total_extra_time
 * @property string|null $assessment_extra_time
 *
 * @property ApiAssessment $assessment
 */
class ApiAssessmentCandidateDetails extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'api_assessment_candidate_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['candidate_id', 'assessment_id', 'testtaker_id'], 'required'],
            [['candidate_id', 'assessment_id', 'testtaker_id'], 'integer'],
            [['test_taker_photos', 'geoip', 'user_agent', 'assessment_benchmark', 'tests_detail'], 'string'],
            [['assessment_name', 'invited', 'status', 'has_consumed_credit', 'content_type_name', 'average', 'is_exited_full_screen', 'is_left_screen', 'modified', 'last_activity', 'highlight', 'ip', 'repeated_ip', 'role', 'review', 'stage', 'reminder_sent', 'public_link', 'anti_cheating_photos_removed', 'is_camera_enabled', 'is_english_native_language', 'accessibility_condition_description', 'accessibility_condition_disclose', 'accessibility_condition_extra_time', 'total_extra_time', 'assessment_extra_time'], 'safe'],
            [['assessment_id', 'testtaker_id'], 'unique', 'targetAttribute' => ['assessment_id', 'testtaker_id']],
            [['candidate_id'], 'unique'],
            [['assessment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiAssessments::class, 'targetAttribute' => ['assessment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'candidate_id' => 'Candidate ID',
            'assessment_id' => 'Assessment ID',
            'testtaker_id' => 'Testtaker ID',
            'assessment_name' => 'Assessment Name',
            'invited' => 'Invited',
            'status' => 'Status',
            'has_consumed_credit' => 'Has Consumed Credit',
            'content_type_name' => 'Content Type Name',
            'average' => 'Average',
            'test_taker_photos' => 'Test Taker Photos',
            'is_exited_full_screen' => 'Is Exited Full Screen',
            'is_left_screen' => 'Is Left Screen',
            'modified' => 'Modified',
            'last_activity' => 'Last Activity',
            'highlight' => 'Highlight',
            'ip' => 'Ip',
            'repeated_ip' => 'Repeated Ip',
            'geoip' => 'Geoip',
            'role' => 'Role',
            'user_agent' => 'User Agent',
            'review' => 'Review',
            'stage' => 'Stage',
            'reminder_sent' => 'Reminder Sent',
            'public_link' => 'Public Link',
            'assessment_benchmark' => 'Assessment Benchmark',
            'tests_detail' => 'Tests Detail',
            'anti_cheating_photos_removed' => 'Anti Cheating Photos Removed',
            'is_camera_enabled' => 'Is Camera Enabled',
            'is_english_native_language' => 'Is English Native Language',
            'accessibility_condition_description' => 'Accessibility Condition Description',
            'accessibility_condition_disclose' => 'Accessibility Condition Disclose',
            'accessibility_condition_extra_time' => 'Accessibility Condition Extra Time',
            'total_extra_time' => 'Total Extra Time',
            'assessment_extra_time' => 'Assessment Extra Time',
        ];
    }

    /**
     * Gets query for [[Assessment]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentQuery
     */
    public function getAssessment() {
        return $this->hasOne(ApiAssessment::class, ['id' => 'assessment_id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateDetailsQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApiAssessmentCandidateDetailsQuery(get_called_class());
    }

}
