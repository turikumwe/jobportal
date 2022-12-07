<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ussd_jobseeker".
 *
 * @property int $id
 * @property string $nid
 * @property string $names
 * @property string $dob
 * @property string $domain
 * @property string $district
 * @property string $education_level
 * @property string $telephone
 */
class UssdJobseeker extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ussd_jobseeker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dob'], 'safe'],
            [['nid', 'names', 'domain', 'district', 'education_level', 'telephone'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nid' => 'Nid',
            'names' => 'Names',
            'dob' => 'Dob',
            'domain' => 'Domain',
            'district' => 'District',
            'education_level' => 'Education Level',
            'telephone' => 'Telephone',
        ];
    }
}
