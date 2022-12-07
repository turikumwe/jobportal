<?php

namespace frontend\modules\abroad\models;

use Yii;

/**
 * This is the model class for table "abroad_share_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $share_id
 * @property int $created_by
 * @property string $created_on
 * @property int $modified_by
 * @property string $modified_on
 *
 * @property User $user
 */
class AbroadShareProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'abroad_share_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'share_id'], 'required'],
            [['user_id', 'created_by', 'modified_by'], 'integer'],
            [['created_on', 'modified_on'], 'safe'],
            [['share_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'share_id' => 'Share',
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
