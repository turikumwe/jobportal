<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_village}}".
 *
 * @property int $id
 * @property int $code
 * @property string $village
 * @property int $cell_id
 * @property string $status
 * @property int $fid
 *
 * @property Address[] $addresses
 * @property SCell $cell
 */
class SVillage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_village}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code', 'village', 'cell_id', 'status', 'fid'], 'required'],
            [['id', 'code', 'cell_id', 'fid'], 'integer'],
            [['village'], 'string', 'max' => 45],
            [['status'], 'string', 'max' => 10],
            [['id'], 'unique'],
            [['cell_id'], 'exist', 'skipOnError' => true, 'targetClass' => SCell::className(), 'targetAttribute' => ['cell_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'village' => Yii::t('app', 'Village'),
            'cell_id' => Yii::t('app', 'Cell ID'),
            'status' => Yii::t('app', 'Status'),
            'fid' => Yii::t('app', 'Fid'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['village_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCell()
    {
        return $this->hasOne(SCell::className(), ['id' => 'cell_id']);
    }
}
