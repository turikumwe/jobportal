<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linkedinurl".
 *
 * @property int $id
 * @property int $user_id
 * @property string $url
 * @property int $created_by
 * @property string $created_on
 * @property int $modified_by
 * @property string $modified_on
 *
 * @property User $user
 */
class Linkedinurl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linkedinurl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_by', 'modified_by'], 'integer'],
            [['created_on', 'modified_on'], 'safe'],
            [['url'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'url' => 'Url',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'modified_by' => 'Modified By',
            'modified_on' => 'Modified On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
