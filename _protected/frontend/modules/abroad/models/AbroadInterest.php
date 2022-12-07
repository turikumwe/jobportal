<?php

namespace frontend\modules\abroad\models;

use Yii;

/**
 * This is the model class for table "abroad_interest".
 *
 * @property int $id
 * @property int $user_id
 * @property int $interest_id
 * @property int $created_by
 * @property string $created_on
 * @property int $modified_by
 * @property string $modified_on
 *
 * @property SInterest $interest
 * @property User $user
 */
class AbroadInterest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'abroad_interest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'interest_id'], 'required'],
            [['user_id', 'interest_id', 'created_by', 'modified_by'], 'integer'],
            [['created_on', 'modified_on'], 'safe'],
            [['interest_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\SInterest::className(), 'targetAttribute' => ['interest_id' => 'id']],
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
            'interest_id' => 'Interest',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'modified_by' => 'Modified By',
            'modified_on' => 'Modified On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterest()
    {
        return $this->hasOne(SInterest::className(), ['id' => 'interest_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
