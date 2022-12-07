<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_domain_cat3}}".
 *
 * @property string $id
 * @property string $subcategory_cat3
 */
class SDomainCat3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%s_domain_cat3}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'subcategory_cat3'], 'required'],
            [['id'], 'string', 'max' => 4],
            [['subcategory_cat3'], 'string', 'max' => 200],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'subcategory_cat3' => Yii::t('common', 'Subcategory Cat3'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SDomainCat3Query the active query used by this AR class.
     */
    public static function find()
    {
        return new SDomainCat3Query(get_called_class());
    }
}
