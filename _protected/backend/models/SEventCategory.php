<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_event_category}}".
 *
 * @property int $id
 * @property string $category
 *
 * @property ServiceEvent[] $serviceEvents
 */
class SEventCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_event_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['category'], 'string', 'max' => 100],
            [['category'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'category' => Yii::t('backend', 'Category'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceEvents()
    {
        return $this->hasMany(ServiceEvent::className(), ['event_category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SEventCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SEventCategoryQuery(get_called_class());
    }
}
