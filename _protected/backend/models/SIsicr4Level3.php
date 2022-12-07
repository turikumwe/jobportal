<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isicr4_level3}}".
 *
 * @property int $id
 * @property int $level2_id
 * @property string $code
 * @property string $isic_group_descr
 *
 * @property SIsicr4Level2 $level2
 * @property SIsicr4Level4[] $sIsicr4Level4s
 */
class SIsicr4Level3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isicr4_level3}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level2_id', 'code', 'isic_group_descr'], 'required'],
            [['level2_id'], 'integer'],
            [['code'], 'string', 'max' => 3],
            [['isic_group_descr'], 'string', 'max' => 200],
            [['level2_id'], 'exist', 'skipOnError' => true, 'targetClass' => SIsicr4Level2::className(), 'targetAttribute' => ['level2_id' => 'id']],
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
            'isic_group_descr' => Yii::t('backend', 'Isic Group Descr'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel2()
    {
        return $this->hasOne(SIsicr4Level2::className(), ['id' => 'level2_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSIsicr4Level4s()
    {
        return $this->hasMany(SIsicr4Level4::className(), ['level3_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsicr4Level3Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsicr4Level3Query(get_called_class());
    }
}
