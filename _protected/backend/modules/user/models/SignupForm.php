<?php

namespace backend\modules\user\models;

use kartik\password\StrengthValidator;
use common\commands\SendEmailCommand;
use backend\modules\user\Module;
use common\models\UserToken;
use yii\base\Exception;
use common\models\User;
use cheatsheet\Time;
use yii\helpers\Url;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $password;

     /**
     * @var
     */
    public $repeat_password;

    public $phone;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('backend', 'This username has already been taken.')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email','required'],

            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'string', 'max' => 20], 
            ['phone','required'],             
            ['phone', 'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('Backend', 'This phone has already been taken.')
            ],

            ['password', 'required'],
            ['repeat_password', 'required'],
            // ['password', 'string', 'min' => 6],
            // ['repeat_password', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match"],

            [['password'], StrengthValidator::class, 'preset'=> StrengthValidator::MEDIUM],
            ['repeat_password', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match"],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('backend', 'Username'),
            'email' => Yii::t('backend', 'E-mail'),
            'password' => Yii::t('backend', 'Password'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function signup($role,$validation=false)
    { 
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            if (!$user->save()) {
                throw new Exception("User couldn't be  saved");
            };
            $user->afterSignup($role);

            Yii::$app->commandBus->handle(new SendEmailCommand([
                'subject' => Yii::t('backend', 'Registration email'),
                'view' => 'public_mediator_registration',
                'to' => $this->email,
                'params' => [
                    'url' => $_SERVER['HTTP_HOST'],
                    'username' => $this->username,
                    'password' => $this->password
                ]
            ]));

            return $user;
        }

        return null;
    }
    /**
     * @return bool
     */
    public function shouldBeActivated()
    {
        /** @var Module $userModule */
        $userModule = Yii::$app->getModule('user');
        if (!$userModule) {
            return false;
        } elseif ($userModule->shouldBeActivated) {
            return true;
        } else {
            return false;
        }
    }
}
