<?php

namespace common\models;

use kartik\password\StrengthValidator;
use common\commands\SendEmailCommand;
use frontend\modules\user\Module;
use common\models\UserToken;
use yii\base\Exception;
use common\models\User;
use cheatsheet\Time;
use yii\helpers\Url;
use yii\base\Model;
use Yii;
use common\models\Winner;
use common\models\WinningNumber;
use yii\helpers\Html;

/**
 * Signup form
 */
class ChangePasswordForm extends \yii\db\ActiveRecord {

    public $password;
    public $repeat_password;

    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend', 'This username has already been used.')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            [
                'email', 'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('Backend', 'This email has already been used.')
            ],
            [
                'email', 'required', 'when' => function ($model) {
                    return $model->required_email == 'required';
                }, 'whenClient' => "function (attribute, value) {
                    return $('#required_email').val() == 'required';
                }"
            ],
            ['phone', 'required'],
            ['phone', 'string', 'min' => 10, 'max' => 13],
            ['phone', 'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('Backend', 'This phone has already been used.')
            ],
            ['password', 'required'],
            ['repeat_password', 'required'],
            ['from_id', 'integer'],
            [['password'], StrengthValidator::class, 'preset' => StrengthValidator::MEDIUM],
            ['repeat_password', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => "Passwords don't match"],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels() {
        return [
            'username' => Yii::t('frontend', 'Username'),
            'email' => Yii::t('frontend', 'E-mail'),
            'password' => Yii::t('frontend', 'Password'),
        ];
    }

}
