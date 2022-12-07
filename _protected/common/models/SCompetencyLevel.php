<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "s_competency_level".
 *
 * @property int $id ID
 * @property string $competency_level Competency level
 */
class SCompetencyLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_competency_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['competency_level'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'competency_level' => Yii::t('frontend', 'Competency level'),
        ];
    }
}
