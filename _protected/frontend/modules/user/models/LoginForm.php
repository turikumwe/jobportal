<?php

namespace frontend\modules\user\models;

use cheatsheet\Time;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $identity;
    public $password;
    public $rememberMe = true;

    private $user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['identity', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'identity' => Yii::t('frontend', 'Username or email'),
            'password' => Yii::t('frontend', 'Password'),
            'rememberMe' => Yii::t('frontend', 'Remember Me'),
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('frontend', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $user = User::find()
                ->andWhere(['or', ['username' => $this->identity], ['email' => $this->identity], ['phone' => $this->identity]])
                ->one();

            // echo $user->role->item_name; die;

            if (isset($user->role->item_name)) {
                if ($user->role->item_name == 'employer') {
                    $profile = $user->employerProfile;
                } elseif ($user->role->item_name == 'user') {
                    $profile = $user->userProfile;
                } elseif ($user->role->item_name == 'abroad') {
                    $profile = $user->userProfile;
                } elseif ($user->role->item_name == 'RDB') {
                    $profile = $user->userProfile;
                } elseif ($user->role->item_name == 'mediator') {
                    $profile = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee;
                } else {
                    $profile = $user->userProfile;
                }

                if ($user->role->item_name != 'administrator') {
                    if ($profile->terminate == 0) {
                        $profile->terminate = 1;
                        $user->status = User::STATUS_ACTIVE;
                        $profile->save(false);
                        $user->save(false);
                    }
                }
            }

            $this->user = User::find()
                ->active()
                ->andWhere(['or', ['username' => $this->identity], ['email' => $this->identity], ['phone' => $this->identity]])
                ->one();
        }

        return $this->user;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? Time::SECONDS_IN_A_MONTH : 0)) {
                return true;
            }
        }
        return false;
    }
}
