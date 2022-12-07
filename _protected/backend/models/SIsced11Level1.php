<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_isced11_level1}}".
 *
 * @property int $id
 * @property string $code
 * @property string $category_cat1
 *
 * @property SIsced11Level2[] $sIsced11Level2s
 */
class SIsced11Level1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_isced11_level1}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'category_cat1'], 'required'],
            [['code'], 'string', 'max' => 4],
            [['category_cat1'], 'string', 'max' => 200],
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
            'category_cat1' => Yii::t('backend', 'Category Cat1'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSIsced11Level2s()
    {
        return $this->hasMany(SIsced11Level2::className(), ['level1_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SIsced11Level1Query the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SIsced11Level1Query(get_called_class());
    }
}
