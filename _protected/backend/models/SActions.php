<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%s_actions}}".
 *
 * @property int $id
 * @property string $action
 *
 * @property ServiceApprenticeship[] $serviceApprenticeships
 */
class SActions extends \yii\db\ActiveRecord {

    const ACTION_STATUS_PUBLISHED = 1;
    const ACTION_STATUS_DRAFT = 2;
    const ACTION_STATUS_REJECTED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%s_actions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['action'], 'required'],
            [['action'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'pk_action' => Yii::t('backend', 'ID'),
            'action' => Yii::t('backend', 'Action'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceApprenticeships() {
        return $this->hasMany(ServiceApprenticeship::className(), ['action_id' => 'pk_action']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SActionsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \backend\models\query\SActionsQuery(get_called_class());
    }

}
