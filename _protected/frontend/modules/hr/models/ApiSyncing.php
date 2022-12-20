<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "api_syncing".
 *
 * @property int $id
 * @property string|null $object_name
 * @property string|null $sync_started
 * @property string|null $sync_ended
 * @property int|null $is_syncing
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class ApiSyncing extends \yii\db\ActiveRecord {

    const OBJECT_NAME_ASSESSMENT = 'assessment';
    const OBJECT_NAME_ASSESSMENT_DETAILS = 'assessment_details';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'api_syncing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['sync_started', 'assessment_id', 'test_taker_id', 'sync_ended', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['is_syncing', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['object_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'object_name' => 'Object Name',
            'sync_started' => 'Sync Started',
            'sync_ended' => 'Sync Ended',
            'is_syncing' => 'Is Syncing',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ApiSyncingQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApiSyncingQuery(get_called_class());
    }

    public static function iSSyncing($object_name, $assessment_id = null, $test_taker_id = null) {

        $object = ApiSyncing::find()->where(['object_name' => $object_name]);
        if (isset($assessment_id)) {
            $object->andWhere(['assessment_id' => $assessment_id]);
        }
        if (isset($test_taker_id)) {
            $object->andWhere(['test_taker_id' => $test_taker_id]);
        }
        $items = $object->one();
        
        if (isset($items)) {
            if ($items->is_syncing == 1) {
                return true;
            }
        }
        return false;
    }

}
