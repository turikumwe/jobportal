<?php

namespace frontend\modules\user\models;

use common\commands\SendEmailCommand;
use common\models\UserToken;
use common\models\User;
use yii\helpers\Html;
use cheatsheet\Time;
use yii\base\Model;
use Yii;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    /**
     * @var user email
     */
    public $email;

    public $phone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],

            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such phone.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);
      
        if ($user) {
            $token = UserToken::create($user->id, UserToken::TYPE_PASSWORD_RESET, Time::SECONDS_IN_A_DAY);

            if ($user->save()) {
                return Yii::$app->commandBus->handle(new SendEmailCommand([
                    'to' => $this->email,
                    'subject' => Yii::t('frontend', 'Password reset for {name}', ['name' => Yii::$app->name]),
                    'view' => 'passwordResetToken',
                    'params' => [
                        'user' => $user,
                        'token' => $token->token
                    ]
                ]));
            }
        }

        return false;
    }

    public function sendSMS()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'phone' => $this->phone,
        ]);

        if ($user) {
            $token = UserToken::create($user->id, UserToken::TYPE_PASSWORD_RESET, Time::SECONDS_IN_A_DAY);
            $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/sign-in/reset-password']);
            $message = "Follow the link below to reset your password:". $resetLink."?token=".$token;
    
            if ($user->save()) {
                return Yii::$app->sms->send($this->phone, $message);
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('frontend', 'E-mail')
        ];
    }
}
