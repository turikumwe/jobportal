<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%labels}}".
 *
 * @property int $id
 * @property string $attribute
 * @property string $definition
 */
class Labels extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%labels}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['definition'], 'required'],
            [['definition'], 'string'],
            [['attribute'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'attribute' => Yii::t('common', 'Attribute'),
            'definition' => Yii::t('common', 'Definition'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return LabelsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LabelsQuery(get_called_class());
    }

    public static function definition($name){
    
        return isset(Labels::find()->label($name)->one()->definition) ? Labels::find()->label($name)->one()->definition : 'No definition'; 
        
    }
}
