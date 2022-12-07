<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_training_category}}".
 *
 * @property int $id
 * @property string $trainingcategory
 *
 * @property ServiceApprenticeship[] $serviceApprenticeships
 */
class STrainingCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_training_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trainingcategory'], 'required'],
            [['trainingcategory'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'trainingcategory' => Yii::t('backend', 'Trainingcategory'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceApprenticeships()
    {
        return $this->hasMany(ServiceApprenticeship::className(), ['apprenticeship_category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\STrainingCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\STrainingCategoryQuery(get_called_class());
    }
}
