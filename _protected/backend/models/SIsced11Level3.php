<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isced11_level3}}".
 *
 * @property int $id
 * @property int $level2_id
 * @property string $code
 * @property string $subcategory_cat3
 *
 * @property SIsced11Level2 $level2
 */
class SIsced11Level3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isced11_level3}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level2_id', 'code', 'subcategory_cat3'], 'required'],
            [['level2_id'], 'integer'],
            [['code'], 'string', 'max' => 4],
            [['subcategory_cat3'], 'string', 'max' => 200],
            [['level2_id'], 'exist', 'skipOnError' => true, 'targetClass' => SIsced11Level2::className(), 'targetAttribute' => ['level2_id' => 'id']],
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
            'subcategory_cat3' => Yii::t('backend', 'Subcategory Cat3'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel2()
    {
        return $this->hasOne(SIsced11Level2::className(), ['id' => 'level2_id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsced11Level3Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsced11Level3Query(get_called_class());
    }
}
