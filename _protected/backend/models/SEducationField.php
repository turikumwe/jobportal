<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_education_field}}".
 *
 * @property int $id
 * @property string $field
 *
 * @property Education[] $educations
 */
class SEducationField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_education_field}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field'], 'required'],
            [['field'], 'string', 'max' => 100],
            [['field'], 'unique'],
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
            'field' => Yii::t('app', 'Field'),
            'status' => Yii::t('app', 'Status'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducations()
    {
        return $this->hasMany(Education::class, ['education_field_id' => 'id']);
    }

    public static function find(){
        return parent::find()
            ->onCondition([
                'and',
                ['!=', static::tableName() . '.id', 2],
                ['!=', static::tableName() . '.id', 5]
            ]);
    }
}
