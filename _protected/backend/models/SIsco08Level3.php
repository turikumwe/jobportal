<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isco08_level3}}".
 *
 * @property int $id
 * @property int $level2_id
 * @property string $code
 * @property string $cat3_description
 *
 * @property SIsco08Level2 $level2
 * @property SIsco08Level4[] $sIsco08Level4s
 */
class SIsco08Level3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isco08_level3}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level2_id', 'code', 'cat3_description'], 'required'],
            [['level2_id'], 'integer'],
            [['code'], 'string', 'max' => 4],
            [['cat3_description'], 'string', 'max' => 200],
            [['level2_id'], 'exist', 'skipOnError' => true, 'targetClass' => SIsco08Level2::className(), 'targetAttribute' => ['level2_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'level2_id' => Yii::t('backend', 'Level2 ID'),
            'code' => Yii::t('backend', 'Code'),
            'cat3_description' => Yii::t('backend', 'Cat3 Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel2()
    {
        return $this->hasOne(SIsco08Level2::className(), ['id' => 'level2_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSIsco08Level4s()
    {
        return $this->hasMany(SIsco08Level4::className(), ['level3_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsco08Level3Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsco08Level3Query(get_called_class());
    }
}
