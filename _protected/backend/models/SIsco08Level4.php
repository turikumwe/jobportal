<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isco08_level4}}".
 *
 * @property int $id
 * @property string $code
 * @property int $level3_id
 * @property string $occupation
 *
 * @property JsExperience[] $jsExperiences
 * @property SIsco08Level3 $level3
 */
class SIsco08Level4 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isco08_level4}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'level3_id', 'occupation'], 'required'],
            [['level3_id'], 'integer'],
            [['code'], 'string', 'max' => 4],
            [['occupation'], 'string', 'max' => 255],
            [['level3_id'], 'exist', 'skipOnError' => true, 'targetClass' => SIsco08Level3::className(), 'targetAttribute' => ['level3_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'code' => Yii::t('backend', 'Code'),
            'level3_id' => Yii::t('backend', 'Level3 ID'),
            'occupation' => Yii::t('backend', 'Occupation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJsExperiences()
    {
        return $this->hasMany(JsExperience::className(), ['occupation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel3()
    {
        return $this->hasOne(SIsco08Level3::className(), ['id' => 'level3_id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsco08Level4Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsco08Level4Query(get_called_class());
    }
}
