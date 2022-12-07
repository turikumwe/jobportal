<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%s_ownership}}".
 *
 * @property int $id
 * @property int $employertype_id
 * @property string $ownership
 *
 * @property EmplEmployer[] $emplEmployers
 */
class SOwnership extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_ownership}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employertype_id'], 'integer'],
            [['ownership'], 'required'],
            [['ownership'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'employertype_id' => Yii::t('common', 'Employertype ID'),
            'ownership' => Yii::t('common', 'Ownership'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEmployers()
    {
        return $this->hasMany(EmplEmployer::className(), ['ownership_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SOwnershipQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SOwnershipQuery(get_called_class());
    }
}
