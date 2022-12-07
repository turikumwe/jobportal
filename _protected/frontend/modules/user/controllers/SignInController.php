<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Response;
use yii\base\Exception;
use common\models\User;
use yii\filters\VerbFilter;
use common\models\UserToken;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\authclient\AuthAction;
use yii\filters\AccessControl;
use common\models\UserProfile;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidArgumentException;
use common\commands\SendEmailCommand;
use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\SignupForm;
use frontend\modules\user\models\ResetPasswordForm;
use frontend\modules\user\models\PasswordResetRequestForm;

/**
 * Class SignInController
 * @package frontend\modules\user\controllers
 * @author Eugene Terentev <eugene@terentev.net>
 */
class SignInController extends \yii\web\Controller {

    /**
     * @return array
     */
    public function actions() {
        return [
            'oauth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'successOAuthCallback']
            ]
        ];
    }

    /**
     * @return array
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'signup', 'login', 'login-by-pass', 'request-password-reset', 'reset-password', 'oauth', 'activation', 'recommendation'
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'recommendation'
                        ],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => [
                            'signup', 'login', 'request-password-reset', 'reset-password', 'oauth', 'activation'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['/user/default/index']);
                        }
                    ],
                    [
                        'actions' => ['logout', 'terminate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    //'logout' => ['post'],
                    'terminate' => ['post']
                ]
            ]
        ];
    }

    /**
     * @return array|string|Response
     */
    public function actionLogin() {
//        echo env('SESSION_DURATION').'<br />';
//        echo time();
//        $expire_time = time() + 300;
//        echo 'Login: '. date('d M Y H:i:s Z',time());
//        exit();
        $model = new LoginForm();
        if (Yii::$app->request->isAjax) {
            $model->load($_POST);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //Save user 
            if (Yii::$app->user->can('manager')) {
                return $this->redirect(Yii::$app->link->frontendUrl('/'));
            } elseif (Yii::$app->user->can('mediator')) {
                //Check if the Mediator institution is active
                $user = User::findOne(Yii::$app->user->id);
                $user_mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;

                if ($user_mediator->mediator_status != 1 || $user->status != 2) {
                    return $this->redirect(Yii::$app->link->frontendUrl('/user/sign-in/logout'));
                }
                return $this->redirect(Yii::$app->link->frontendUrl('/mediator/md-mediator/'));
            } elseif (Yii::$app->user->can('employer')) {
                return $this->redirect(Yii::$app->link->frontendUrl('/employer/empl-employer'));
            } else {

                return $this->redirect(Yii::$app->link->frontendUrl('/jobseeker/user-profile/dashboard'));
            }
        }

        //Track views
        Yii::$app->commandBus->handle(new \common\commands\AddToTimelineCommand([
                    'category' => 'visitor',
                    'event' => 'login-view',
                    'data' => [
                        'created_at' => time(),
                    ]
        ]));

        return $this->render('login', [
                    'model' => $model
        ]);
    }

    public function actionRecommendation($to_email, $from_id, $signup = null) {
        $model = new LoginForm();
        $signup = new SignupForm();
        $userProfile = new UserProfile();

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->link->frontendUrl('/jobseeker/js-recommendation/recommendation?user_id=' . $from_id));
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->redirect(Yii::$app->link->frontendUrl('/jobseeker/js-recommendation/recommendation?user_id=' . $from_id));
            } elseif ($signup->load(Yii::$app->request->post())) {
                $userProfile->load(Yii::$app->request->post());
                $user = $signup->signupRecommandation(User::ROLE_USER);

                if ($user) {
                    Yii::$app->getUser()->login($user);
                    $userProfile->locale = Yii::$app->language;
                    $userProfile->user_id = $user->id;
                    $userProfile->created_by = $user->id;
                    $userProfile->updated_by = $user->id;
                    $userProfile->save();
                    return $this->redirect($jobportal . '/jobseeker/js-recommendation/recommendation?user_id=' . $from_id);
                } else {
                    return $this->render('recommendation', [
                                'id' => $from_id,
                                'model' => $model,
                                'email' => $to_email,
                                'signup' => $signup,
                                'userProfile' => $userProfile
                    ]);
                }
            } else {
                return $this->render('recommendation', [
                            'id' => $from_id,
                            'model' => $model,
                            'email' => $to_email,
                            'signup' => $signup,
                            'userProfile' => $userProfile
                ]);
            }
        }
    }

    public function actionTerminate() {
        $user = User::findOne(Yii::$app->user->id);

        if ($user) {
            $user->status = User::STATUS_DELETED;
            if ($user->save(false)) {
                if (Yii::$app->user->can('employer')) {
                    $profile = $user->employerProfile;
                } elseif (Yii::$app->user->can('user')) {
                    $profile = $user->userProfile;
                } else {
                    $profile = $user->mediatorProfile;
                }

                $profile->terminate = 0;

                if ($profile->save(false)) {
                    Yii::$app->user->logout();
                }
            }
            return $this->goHome();
        }
        return null;
    }

    /**
     * @param $token
     * @return array|string|Response
     * @throws ForbiddenHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionLoginByPass($token) {
        if (!$this->module->enableLoginByPass) {
            throw new NotFoundHttpException();
        }

        $user = UserToken::use($token, UserToken::TYPE_LOGIN_PASS);

        if ($user === null) {
            throw new ForbiddenHttpException();
        }

        Yii::$app->user->login($user);
        return $this->goHome();
    }

    /**
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->link->frontendUrl("/"));
        //return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();
            if ($user) {
                if ($model->shouldBeActivated()) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t(
                                'frontend',
                                'Your account has been successfully created. Check your email for further instructions.'
                        ),
                        'options' => ['class' => 'alert-success']
                    ]);
                } else {
                    Yii::$app->getUser()->login($user);
                }
                return $this->goHome();
            }
        }

        return $this->render('signup', [
                    'model' => $model
        ]);
    }

    /**
     * @param $token
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionActivation($token) {
        $token = UserToken::find()
                ->byType(UserToken::TYPE_ACTIVATION)
                ->byToken($token)
                ->notExpired()
                ->one();

        // var_dump($token); die;

        if (!$token) {
            $model = new LoginForm();
            Yii::$app->getSession()->setFlash('alert', [
                'body' => Yii::t('frontend', 'You have already activated your account.'),
                'options' => ['class' => 'alert-danger']
            ]);

            return $this->redirect(Yii::$app->link->frontendUrl('/user/sign-in/login/'));
        }

        $user = $token->user;

        $user->updateAttributes([
            'status' => User::STATUS_ACTIVE
        ]);

        $token->delete();
        Yii::$app->getUser()->login($user);
        Yii::$app->getSession()->setFlash('alert', [
            'body' => Yii::t('frontend', 'Your account has been successfully activated.'),
            'options' => ['class' => 'alert-success']
        ]);
        if (Yii::$app->user->can('user')) {
            return $this->redirect(Yii::$app->link->frontendUrl('/jobseeker/user-profile/'));
        }
        if (Yii::$app->user->can('employer')) {
            return $this->redirect(Yii::$app->link->frontendUrl('/employer/empl-employer'));
        }

        return $this->redirect(Yii::getAlias('@frontendUrl') . '/');
    }

    /**
     * @return string|Response
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($model->email)) {
                if ($model->sendEmail()) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t('frontend', 'Check your email for further instructions.'),
                        'options' => ['class' => 'alert-success']
                    ]);
                    $model = new PasswordResetRequestForm();
                } else {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t('frontend', 'Sorry, we are unable to reset password for email provided.'),
                        'options' => ['class' => 'alert-danger']
                    ]);
                }
            } else {
                if ($model->sendSMS()) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t('frontend', 'Check your phone for further instructions.'),
                        'options' => ['class' => 'alert-success']
                    ]);

                    $model = new PasswordResetRequestForm();
                } else {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t('frontend', 'Sorry, we are unable to reset password for pho provided.'),
                        'options' => ['class' => 'alert-danger']
                    ]);
                }
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return string|Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('alert', [
                'body' => Yii::t('frontend', 'New password was saved.'),
                'options' => ['class' => 'alert-success']
            ]);

            $model->password = '';
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    /**
     * @param $client \yii\authclient\BaseClient
     * @return bool
     * @throws Exception
     */
    public function successOAuthCallback($client) {
        // use BaseClient::normalizeUserAttributeMap to provide consistency for user attribute`s names
        $attributes = $client->getUserAttributes();
        $user = User::find()->where([
                    'oauth_client' => $client->getName(),
                    'oauth_client_user_id' => ArrayHelper::getValue($attributes, 'id')
                ])->one();
        if (!$user) {
            $user = new User();
            $user->scenario = 'oauth_create';
            $user->username = ArrayHelper::getValue($attributes, 'login');
            // check default location of email, if not found as in google plus dig inside the array of emails
            $email = ArrayHelper::getValue($attributes, 'email');
            if ($email === null) {
                $email = ArrayHelper::getValue($attributes, ['emails', 0, 'value']);
            }
            $user->email = $email;
            $user->oauth_client = $client->getName();
            $user->oauth_client_user_id = ArrayHelper::getValue($attributes, 'id');
            $user->status = User::STATUS_ACTIVE;
            $password = Yii::$app->security->generateRandomString(8);
            $user->setPassword($password);
            if ($user->save()) {
                $profileData = [];
                if ($client->getName() === 'facebook') {
                    $profileData['firstname'] = ArrayHelper::getValue($attributes, 'first_name');
                    $profileData['lastname'] = ArrayHelper::getValue($attributes, 'last_name');
                }
                $user->afterSignup($profileData);
                $sentSuccess = Yii::$app->commandBus->handle(new SendEmailCommand([
                            'view' => 'oauth_welcome',
                            'params' => ['user' => $user, 'password' => $password],
                            'subject' => Yii::t('frontend', '{app-name} | Your login information', ['app-name' => Yii::$app->name]),
                            'to' => $user->email
                ]));
                if ($sentSuccess) {
                    Yii::$app->session->setFlash(
                            'alert',
                            [
                                'options' => ['class' => 'alert-success'],
                                'body' => Yii::t('frontend', 'Welcome to {app-name}. Email with your login information was sent to your email.', [
                                    'app-name' => Yii::$app->name
                                ])
                            ]
                    );
                }
            } else {
                // We already have a user with this email. Do what you want in such case
                if ($user->email && User::find()->where(['email' => $user->email])->count()) {
                    Yii::$app->session->setFlash(
                            'alert',
                            [
                                'options' => ['class' => 'alert-danger'],
                                'body' => Yii::t('frontend', 'We already have a user with email {email}', [
                                    'email' => $user->email
                                ])
                            ]
                    );
                } else {
                    Yii::$app->session->setFlash(
                            'alert',
                            [
                                'options' => ['class' => 'alert-danger'],
                                'body' => Yii::t('frontend', 'Error while oauth process.')
                            ]
                    );
                }
            };
        }
        if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
            return true;
        }

        throw new Exception('OAuth error');
    }

}
