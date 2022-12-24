<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_candidate_bulk_result_send".
 *
 * @property int $id
 * @property int $candidate_id
 * @property int $test_taker_id
 * @property string $created_on
 * @property string|null $sent_on
 */
class ApiAssessmentCandidateBulkResultSend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'api_assessment_candidate_bulk_result_send';
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
            'created_on' => 'Created On',
            'sent_on' => 'Sent On',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ApiAssessmentCandidateBulkResultSendQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApiAssessmentCandidateBulkResultSendQuery(get_called_class());
    }
}
