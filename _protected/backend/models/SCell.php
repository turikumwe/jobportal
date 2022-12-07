<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_cell}}".
 *
 * @property int $id
 * @property string $cell
 * @property int $sector_id
 *
 * @property SGeosector $sector
 * @property SVillage[] $sVillages
 */
class SCell extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_cell}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'sector_id'], 'integer'],
            [['cell'], 'string', 'max' => 45],
            [['id'], 'unique'],
            [['sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => SGeosector::className(), 'targetAttribute' => ['sector_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cell' => Yii::t('app', 'Cell'),
            'sector_id' => Yii::t('app', 'Sector ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSector()
    {
        return $this->hasOne(SGeosector::className(), ['id' => 'sector_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSVillages()
    {
        return $this->hasMany(SVillage::className(), ['cell_id' => 'id']);
    }
}
