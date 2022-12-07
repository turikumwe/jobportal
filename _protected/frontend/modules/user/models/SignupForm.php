<?php

namespace frontend\modules\user\models;

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
    public $phone;

     /**
     * @var
     */
    public $repeat_password;
    public $required_email;
    public $from_id;

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
                'email','required', 'when' => function ($model) {
                    return  $model->required_email == 'required';
                },'whenClient' => "function (attribute, value) {
                    return $('#required_email').val() == 'required';
                }"
            ],

            ['phone','required'],
            ['phone', 'string','min' => 10, 'max' => 13],          
            ['phone', 'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('Backend', 'This phone has already been used.')
            ],

            ['password', 'required'],
            ['repeat_password', 'required'],

            ['from_id', 'integer'],

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
            'email' => Yii::t('frontend', 'E-mail'),
            'password' => Yii::t('frontend', 'Password'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function signup($role,$validation=true)
    {
        $session = Yii::$app->session;
        $name = $session->get('name');

        if ($this->validate()) {
            $shouldBeActivated = ($validation) ? $this->shouldBeActivated() : false;
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
            $user->setPassword($this->password);

            if (!$user->save()) {
                throw new Exception("User couldn't be  saved");
            };

            $user->afterSignup($role);
            if ($shouldBeActivated) {
                $token = UserToken::create(
                    $user->id,
                    UserToken::TYPE_ACTIVATION,
                    Time::SECONDS_IN_A_DAY
                );
                $number = 0;
                $userid = base64_encode($user->id);
                $winningnumber = new WinningNumber();
                $number = $winningnumber::find()->where(['number' => $userid])->count();
                $dt = date('Y-m-d');
                
                if($dt='2019-09-04')
                    $dtx='2019-09-04';
                if ($dt = '2019-09-05')
                    $dtx = '2019-09-05';
                if ($dt = '2019-09-06')
                    $dtx = '2019-09-06';

                if($role == 'user' && $number == 1 && $dt == $dtx)
                {
                    $winner = new Winner();
                    $winner->user_id = $user->id;
                    $winner->created_by = $user->id;

                    Yii::$app->commandBus->handle(new SendEmailCommand([
                        'subject' => Yii::t('frontend', 'KoraKwitaIzina19 - TICKET WINNER - Activation email'),
                        'view' => 'activation',
                        'to' => $this->email,
                        'body' => ' <body class="container">
                                    Dear '.$name.',<br><br>
                                    Thank you for registering on Kora!<br><br> You are one of the lucky winners of the 
                                    <b>#KoraKwitaIzina19</b> ticket giveaway. <b>You have won a Regular ticket to the Kwita 
                                    Izina Concert on September 7th, 2019 featuring Ne-Yo and Meddy!</b><br><br>
                                    <b>To activate your account, please </b>: '. Html::a('click here', Url::to(['/user/sign-in/activation', 'token' => $token->token], 'https',true)).'<br><br>
                                    The name associated with this e-mail address and Kora profile is '.$name. '. 
                                    Please bring your government issued ID card to redeem your free ticket at 
                                    RDB offices KN 5 Rd, KG 9 Ave (Gishushu) from Thursday August 29th, 2019 up until 
                                    September 6th 2019 between the hours of 2pm and 5pm.<br><br>
                                    If you have any questions or concerns you can contact us at daniel.katurebe@rdb.rw 
                                    or 0785836437. <br><br>
                                    Kind regards,<br>
                                    '.Html::img(Yii::getAlias("@storageUrl")."/source/1/kora.png").'</body>',
                        // 'message' => attach(Yii::getAlias("@storageUrl")."/source/1/homepage.png"),
                        // 'params' => [
                        //     'url' => Url::to(['/user/sign-in/activation', 'token' => $token->token,'validation' => $validation], true)
                        // ]
                    ]));

                    if (!$winner->save()) {
                        var_dump($winner->errors);
                    }

                } else{
                    Yii::$app->commandBus->handle(new SendEmailCommand([
                       'subject' => Yii::t('frontend', 'Activation email'),
                        'view' => 'activation',
                        'to' => $this->email,
                        'body' => 'Thank you for registering in Kora Jobportal.<br><br> 
                                    Your username is '.$this->email.' <br><br>
                                    <b>Activate your account</b>: '. Html::a('Click here', Url::to(['/user/sign-in/activation', 'token' => $token->token], 'https', true)).'
                                    <br><br>Regards',
                        // 'params' => [
                        //     'url' => Url::to(['/user/sign-in/activation', 'token' => $token->token,'validation' => $validation], true)
                        // ]
                        // Html::a('Click here', Url::to(['/user/sign-in/activation', 'token' => $token->token], true)) // backup
                    ])); 
                }   
            }
            return $user;
        }

        return null;
    }

    public function signupRecommandation($role)
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
