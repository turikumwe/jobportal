<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "s_kora_known_through".
 *
 * @property int $id
 * @property string $through
 */
class SKoraKnownThrough extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_kora_known_through';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['through'], 'string', 'max' => 200],
            [['through'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'through' => Yii::t('backend', 'Through'),
        ];
    }
}
