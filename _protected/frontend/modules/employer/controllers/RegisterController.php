<?php

namespace frontend\modules\employer\controllers;

use frontend\modules\user\models\SignupForm;
use common\models\EmplEmployer;
use common\models\UserProfile;
use common\models\EmplAddress;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\User;
use yii\web\Response;
use Yii;

/**
 * Class SignInController
 * @package frontend\modules\user\controllers
 * @author Eugene Terentev <eugene@terentev.net>
 */
class RegisterController extends \yii\web\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index'
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'index'
                        ],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['/employer/default/index']);
                        }
                    ],
                ]
            ],
        ];
    }

    /**
     * @return string|Response
     */
    public function actionIndex() {
        $model = new SignupForm();
        $employer = new EmplEmployer();
        $address = new EmplAddress();

        $saved = false;

        $trans = Yii::$app->db->beginTransaction();
        try {
            if ($model->load(Yii::$app->request->post())) {

                $employer->load(Yii::$app->request->post());
                $address->load(Yii::$app->request->post());

                $user = $model->signup(User::ROLE_EMPLOYER);

                if (is_null($user)) {
                    return $this->render('register', [
                                'model' => $model,
                                'employer' => $employer,
                                'address' => $address,
                    ]);
                }

                if ($user) {

                    $employer->id = $user->id;
                    $employer->tin = $employer->tinNumber();
                    $employer->created_by = $user->id;
                    $employer->updated_by = $user->id;

                    $address->employer_id = $user->id;
                    $address->phone_number = $user->phone;
                    $address->email_address = $user->email;
                    $address->created_by = $user->id;
                    $address->updated_by = $user->id;

                    // print"<pre>";
                    // var_dump($address);
                    // print"</pre>";
                    // die;

                    if ($employer->save()) {

                        if ($address->save(false)) {
                            $trans->commit();
                            $saved = true;
                        }
                    }

                    if ($saved) {

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

                        $model = new SignupForm();
                        $employer = new EmplEmployer();
                        $address = new EmplAddress();

                        return $this->render('register', [
                                    'model' => $model,
                                    'employer' => $employer,
                                    'address' => $address,
                        ]);
                    } else {

                        Yii::$app->getSession()->setFlash('alert', [
                            'body' => Yii::t(
                                    'frontend',
                                    'Error:Your account has not been created.'
                            ),
                            'options' => ['class' => 'alert-danger']
                        ]);

                        return $this->render('register', [
                                    'model' => $model,
                                    'employer' => $employer,
                                    'address' => $address,
                        ]);
                    }
                }
            }
        } catch (Exception $exc) {
            echo 9;
            die;
            $trans->rollBack();
        }


        return $this->render('register', [
                    'model' => $model,
                    'employer' => $employer,
                    'address' => $address,
        ]);
    }

}
