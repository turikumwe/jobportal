<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%js_experience}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $company
 * @property int $occupation_id
 * @property string $exact_position
 * @property int $experience_in_this_occupation
 * @property string $start_date
 * @property string $end_date
 * @property int $created_by
 * @property string $created_at
 * @property int $deleted_by
 * @property string $deleted_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property EmplEmployer $company
 * @property SIsco08Level4 $occupation
 * @property User $user
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 */
class FavoriteJobs extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }
   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%favoritejobs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'job_id'], 'integer'],
            [['job_id'], 'required'],
           
            [['status'], 'default', 'value'=> 1],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'user_id' => Yii::t('frontend', 'Job seeker'),
            'job_id' => Yii::t('frontend', 'job'),
            'status' => Yii::t('frontend', 'status'),
             
        ];
    }   

     
    /**
     * {@inheritdoc}
     * @return \common\models\query\JsExperienceQuery the active query used by this AR class.
     */
    

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}

