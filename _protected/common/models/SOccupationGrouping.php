<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "s_occupation_grouping".
 *
 * @property int $id ID
 * @property string $occupation_grouping Occupation grouping
 * @property string $icon Icon
 */
class SOccupationGrouping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_occupation_grouping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['occupation_grouping', 'icon'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'occupation_grouping' => Yii::t('frontend', 'Occupation grouping'),
            'icon' => Yii::t('frontend', 'Icon'),
        ];
    }
}
