<?php

namespace frontend\modules\user\models;

use common\models\User;
use kartik\password\StrengthValidator;
use Yii;
use yii\base\Model;
use yii\web\JsExpression;

/**
 * Account form
 */
class AccountForm extends Model
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $password_confirm;

    public $phone;
    /**
     * @var User
     */
    private $user;

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->user  = $user;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->username = $user->username;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass' => User::class,
                'message' => Yii::t('frontend', 'This username has already been taken.'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => Yii::$app->user->getId()]]);
                }
            ],
            ['username', 'string', 'min' => 1, 'max' => 255],
            ['phone', 'string', 'min' => 1, 'max' => 20],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => User::class,
                'message' => Yii::t('frontend', 'This email has already been taken.'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => Yii::$app->user->getId()]]);
                }
            ],
            ['password', 'string'],
            [
                'password_confirm',
                'required',
                'when' => function ($model) {
                    return !empty($model->password);
                },
                'whenClient' => new JsExpression("function (attribute, value) {
                    return $('#accountform-password').val().length > 0;
                }")
            ],
            // ['password_confirm', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false],
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
            'username' => Yii::t('frontend', 'Username'),
            'email' => Yii::t('frontend', 'Email'),
            'password' => Yii::t('frontend', 'Password'),
            'password_confirm' => Yii::t('frontend', 'Confirm Password')
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        $this->user->username = $this->username;
        $this->user->email = $this->email;
         $this->user->phone = $this->phone;
        if ($this->password) {
            $this->user->setPassword($this->password);
        }
        return $this->user->save(false);
    }
}
