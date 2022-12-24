<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_candidate_bulk_remove".
 *
 * @property int $id
 * @property int $candidate_id
 * @property int $test_taker_id
 * @property string $removed_on
 * @property string|null $sent_on
 */
class ApiAssessmentCandidateBulkRemove extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'api_assessment_candidate_bulk_remove';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['candidate_id', 'test_taker_id'], 'required'],
            [['candidate_id', 'test_taker_id'], 'integer'],
            [['created_on', 'sent_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'candidate_id' => 'Candidate ID',
            'test_taker_id' => 'Test Taker ID',
            'created_on' => 'Removed On',
            'sent_on' => 'Sent On',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateBulkRemoveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApiAssessmentCandidateBulkRemoveQuery(get_called_class());
    }
}
