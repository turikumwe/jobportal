<?php

namespace frontend\modules\mediator\controllers;

use frontend\modules\user\models\SignupForm;
use yii\filters\AccessControl;
use common\models\MdMediator;
use common\models\MdAddress;
use yii\filters\VerbFilter;
use common\models\User;
use yii\web\Response;
use common\models\CommonPerson;
use Yii;
use common\models\UserProfile;

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
                            'index', 'mediator',
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'index', 'mediator',
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
    public function actionMediator() {
        $request = Yii::$app->request;

        $model = new \common\models\MdEmployees;
        $person = new \common\models\CommonPerson;
        $signupForm = new SignupForm();

        $trans = Yii::$app->db->beginTransaction();
        try {
            if ($signupForm->load($request->post())) {
                $person->load(Yii::$app->request->post());
                $model->load(Yii::$app->request->post());

                $user = $signupForm->signup(User::ROLE_MEDIATOR, User::VALIDATION);

                if (is_null($user)) {
                    return $this->render('mediator', [
                                'model' => $model,
                                'person' => $person,
                                'signupForm' => $signupForm,
                    ]);
                }

                $person->created_by = $user->id;
                $person->updated_by = $user->id;
                $person->phone = $user->phone;
                $person->email = $user->email;
                $person->deleted_by = 0;   //TODO use beheviour 

                $person->save(false);

                $model->id = $user->id;
                $model->created_by = $user->id;
                $model->updated_by = $user->id;
                $model->person_id = $person->id;
                $model->deleted_by = 0;   //TODO use beheviour                        
                $model->save();

                $trans->commit();

                if ($user) {

                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t(
                                'frontend',
                                'The account has been successfully created.'
                        ),
                        'options' => ['class' => 'alert-success']
                    ]);

                    $model = new \common\models\MdEmployees;
                    $person = new \common\models\CommonPerson;
                    $signupForm = new SignupForm();

                    return $this->render('mediator', [
                                'model' => $model,
                                'person' => $person,
                                'signupForm' => $signupForm,
                    ]);
                }
            }
        } catch (Exception $exc) {
            $trans->rollBack();
        }

        return $this->render('mediator', [
                    'model' => $model,
                    'person' => $person,
                    'signupForm' => $signupForm,
        ]);
    }

    public function actionIndex() {
        $model = new SignupForm();
        $mediator = new MdMediator();
        $address = new MdAddress();
        $identification = new CommonPerson();

        $trans = Yii::$app->db->beginTransaction();
        try {
            if ($model->load(Yii::$app->request->post())) {

                $mediator->load(Yii::$app->request->post());
                $address->load(Yii::$app->request->post());
                $identification->load(Yii::$app->request->post());

                //saving for ID NUMBER
                if ($identification->document_id = 1) {
                    $identification->first_name = $identification->first_name;
                    $identification->middle_name = $identification->middle_name;
                    $identification->last_name = $identification->last_name;
                    $identification->gender_id = $identification->gender_id;
                    $identification->id_number = $identification->id_number;
                }
                if ($identification->document_id = 2) {
                    $identification->first_name = $identification->pfirst_name;
                    $identification->middle_name = $identification->pmiddle_name;
                    $identification->last_name = $identification->plast_name;
                    $identification->gender_id = $identification->pgender_id;
                    $identification->passport_number = $identification->passport_number;
                    $identification->country_id = $identification->country_id;
                }

                $user = $model->signup(User::ROLE_MEDIATOR);
                if (is_null($user)) {
                    return $this->render('register', [
                                'model' => $model,
                                'mediator' => $mediator,
                                'address' => $address,
                                'identification' => $identification,
                    ]);
                }
                $identification->created_by = $user->id;
                $identification->updated_by = $user->id;
                //$identification->phone        = $user->phone;
                $identification->email = $user->email;
                $identification->deleted_by = 0;   //TODO use beheviour 

                $identification->save(false);

//
                $mediator->id = $user->id;
                $mediator->created_by = $user->id;
                $mediator->updated_by = $user->id;
                $mediator->save();

                $address->mediator_id = $user->id;
                $address->email_address = $user->email;
                $address->created_by = $user->id;
                $address->updated_by = $user->id;
                $address->save();

                $trans->commit();

                if ($user) {
                    if ($model->shouldBeActivated()) {
                        Yii::$app->session->setFlash('success', "Your account has been successfully created. We will notify you upon account activation.");
                        return Yii::$app->getResponse()->redirect(Yii::getAlias('@frontendUrl').'/user/sign-in/login');
                    } else {
                        Yii::$app->getUser()->login($user);
                    }
                }
            }
        } catch (Exception $exc) {
            $trans->rollBack();
        }

        return $this->render('register', [
                    'model' => $model,
                    'mediator' => $mediator,
                    'address' => $address,
                    'identification' => $identification,
        ]);
    }

}
