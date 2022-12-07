<?php

namespace frontend\modules\abroad\models;

use Yii;

/**
 * This is the model class for table "abroad_employment_status".
 *
 * @property int $id
 * @property int $user_id
 * @property string $status_id
 * @property int $created_by
 * @property string $created_on
 * @property int $modified_by
 * @property string $modified_on
 *
 * @property User $user
 */
class AbroadEmploymentStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'abroad_employment_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status_id'], 'required'],
            [['user_id', 'created_by', 'modified_by'], 'integer'],
            [['created_on', 'modified_on'], 'safe'],
            [['status_id'], 'string', 'max' => 255],
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
            'status_id' => 'Status',
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
