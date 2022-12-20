<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_assessment_test".
 *
 * @property int $id
 * @property int $assessment_id
 * @property string|null $order
 *
 * @property ApiAssessmentTestCoveredSkills[] $apiAssessmentTestCoveredSkills
 * @property ApiAssessmentTestTestList[] $apiAssessmentTestTestLists
 * @property ApiAssessmentTestType[] $apiAssessmentTestTypes
 * @property ApiAssessment $assessment
 */
class ApiAssessmentTest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'api_assessment_test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'assessment_id'], 'required'],
            [['id', 'assessment_id'], 'integer'],
            [['ordering'], 'safe'],
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
            'ordering' => 'Order',
        ];
    }

    /**
     * Gets query for [[ApiAssessmentTestCoveredSkills]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentTestCoveredSkillsQuery
     */
    public function getApiAssessmentTestCoveredSkills()
    {
        return $this->hasMany(ApiAssessmentTestCoveredSkills::class, ['test_id' => 'id']);
    }

    /**
     * Gets query for [[ApiAssessmentTestTestLists]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentTestTestListQuery
     */
    public function getApiAssessmentTestTestLists()
    {
        return $this->hasMany(ApiAssessmentTestTestList::class, ['test_id' => 'id']);
    }

    /**
     * Gets query for [[ApiAssessmentTestTypes]].
     *
     * @return \yii\db\ActiveQuery|ApiAssessmentTestTypeQuery
     */
    public function getApiAssessmentTestTypes()
    {
        return $this->hasMany(ApiAssessmentTestType::class, ['test_id' => 'id']);
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
     * @return ApiAssessmentTestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApiAssessmentTestQuery(get_called_class());
    }
}
