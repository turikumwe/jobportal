<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_Candidate".
 *
 * @property int $id
 * @property int $assessment_id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string|null $invitation_uuid
 * @property string|null $created
 * @property int|null $testtaker_id
 * @property float|null $avg_score
 * @property string|null $is_hired
 * @property string|null $personality_algorithm
 * @property string|null $personality
 * @property string|null $rating
 * @property string|null $review
 * @property string|null $stage
 * @property string|null $status
 * @property string|null $invitation_link
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class ApiAssessmentCandidate extends \yii\db\ActiveRecord {

    public $minimum_score;
    public $maximum_score;

    const CANDIDATE_STATUSES = array(array('id' => 'invited', 'label' => 'invited'), array('id' => 'started', 'label' => 'started'), array('id' => 'completed', 'label' => 'completed'));

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'api_assessment_candidate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['candidate_id', 'assessment_id', 'user_id'], 'integer'],
            [['user_id'], 'required'],
            [['email', 'full_name', 'invitation_uuid', 'created', 'testtaker_id', 'status', 'average', 'is_with_feedback_about_hired', 'reminder_sent', 'last_reminder_sent', 'content_type_name', 'is_hired', 'personality', 'personality_algorithm', 'greenhouse_profile_url', 'stage', 'status_notification', 'modified', 'last_activity', 'rating', 'has_consumed_credit', 'review', 'results_sent', 'invitation_link', 'role','pending_deletion'], 'safe'],
            [['assessment_id', 'user_id'], 'unique', 'targetAttribute' => ['assessment_id', 'user_id']],
            [['candidate_id'], 'unique'],
            [['assessment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiAssessments::class, 'targetAttribute' => ['assessment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'candidate_id' => 'Candidate ID',
            'assessment_id' => 'Assessment ID',
            'user_id' => 'User ID',
            'email' => 'Email',
            'full_name' => 'Full Name',
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
            'modified' => 'Modified',
            'last_activity' => 'Last Activity',
            'rating' => 'Rating',
            'has_consumed_credit' => 'Has Consumed Credit',
            'review' => 'Review',
            'results_sent' => 'Results Sent',
            'invitation_link' => 'Invitation Link',
            'minimum_score' => 'From score',
            'maximum_score' => 'From score',
            'role' => 'Role',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApiAssessmentCandidateQuery(get_called_class());
    }

}
