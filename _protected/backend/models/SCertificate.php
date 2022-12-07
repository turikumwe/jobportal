<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_certificate}}".
 *
 * @property int $id
 * @property string $certificate
 *
 * @property Education[] $educations
 */
class SCertificate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_certificate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['certificate'], 'required'],
            [['certificate'], 'string', 'max' => 100],
            [['certificate'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'certificate' => Yii::t('app', 'Certificate'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducations()
    {
        return $this->hasMany(Education::className(), ['certificate_id' => 'id']);
    }
}
