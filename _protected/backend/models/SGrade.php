<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_grade}}".
 *
 * @property int $id
 * @property string $grade
 *
 * @property Education[] $educations
 */
class SGrade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_grade}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grade'], 'required'],
            [['grade'], 'string', 'max' => 100],
            [['grade'], 'unique'],
            [['status', 'order'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'grade' => Yii::t('app', 'Grade'),
            'status' => Yii::t('app', 'Status'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducations()
    {
        return $this->hasMany(Education::className(), ['grade_id' => 'id']);
    }
}
