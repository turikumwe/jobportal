<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_public_links".
 *
 * @property int $id
 * @property int $assessment_id
 * @property string|null $label
 * @property string|null $public_uuid
 * @property string|null $assessment
 * @property string|null $active
 * @property string|null $candidates_limit
 * @property string|null $candidates_count
 * @property string|null $invitation_link
 * @property string|null $short_invitation_link
 *
 * @property ApiAssessment $assessment0
 */
class ApiAssessmentPublicLinks extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'api_assessment_public_links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'assessment_id'], 'required'],
            [['id', 'assessment_id'], 'integer'],
            [['label', 'public_uuid', 'assessment', 'active', 'candidates_limit', 'candidates_count', 'invitation_link', 'short_invitation_link'], 'safe'],
            [['id'], 'unique'],
            [['assessment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiAssessments::class, 'targetAttribute' => ['assessment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'assessment_id' => 'Assessment ID',
            'label' => 'Label',
            'public_uuid' => 'Public Uuid',
            'assessment' => 'Assessment',
            'active' => 'Active',
            'candidates_limit' => 'Candidates Limit',
            'candidates_count' => 'Candidates Count',
            'invitation_link' => 'Invitation Link',
            'short_invitation_link' => 'Short Invitation Link',
        ];
    }

    /**
     * Gets query for [[Assessment0]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentQuery
     */
    public function getAssessment0() {
        return $this->hasOne(ApiAssessments::class, ['id' => 'assessment_id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentPublicLinksQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApiAssessmentPublicLinksQuery(get_called_class());
    }

}
