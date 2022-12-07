<?php

namespace backend\modules\jobseeker\controllers;

use Yii;
use backend\modules\jobseeker\models\search\UserProfileSearch;
use frontend\modules\user\models\SignupForm;
use yii\web\NotFoundHttpException;
use common\models\JsExperience;
use common\models\UserProfile;
use common\models\JsEducation;
use yii\filters\AccessControl;
use common\models\JsAddress;
use yii\filters\VerbFilter;
use yii\web\Controller;
use common\models\User;
use \yii\web\Response;
use yii\helpers\Html;
use \yii\helpers\ArrayHelper;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserProfile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "UserProfile #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new UserProfile model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        echo "disabled";
        die;
        $request = Yii::$app->request;
        $model = new UserProfile();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new UserProfile",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new UserProfile",
                    'content' => '<span class="text-success">Create UserProfile success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new UserProfile",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->user_id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionRegister() {
        $model = new SignupForm();
        $identification = new UserProfile();
        $education = new JsEducation();
        $address = new JsAddress();
        $experience = new JsExperience();

        $trans = Yii::$app->db->beginTransaction();
        try {

            if ($model->load(Yii::$app->request->post())) {

                $address->load(Yii::$app->request->post());
                $education->load(Yii::$app->request->post());
                $identification->load(Yii::$app->request->post());

                if (!$identification->ageRestriction()) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t('frontend', 'Your age should be above 15 or under 60 years old.'
                        ),
                        'options' => ['class' => 'alert-danger']
                    ]);

                    return $this->render('register/register', [
                                'model' => $model,
                                'identification' => $identification,
                                'education' => $education,
                                'address' => $address
                    ]);
                }

                $user = $model->signup(User::ROLE_USER);
                if (is_null($user)) {
                    return $this->render('register/register', [
                                'model' => $model,
                                'identification' => $identification,
                                'education' => $education,
                                'address' => $address
                    ]);
                }
                $identification->locale = Yii::$app->language;
                $identification->user_id = $user->id;
                $identification->created_by = $user->id;
                $identification->updated_by = $user->id;
                $identification->save();

                $education->user_id = $user->id;
                $education->created_by = $user->id;
                $education->updated_by = $user->id;
                $education->save();

                $address->user_id = $user->id;
                $address->created_by = $user->id;
                $address->updated_by = $user->id;
                $address->emailAddress = $model->email;
                $address->phoneNumber = $model->phone;
                $address->save();

                $experience->user_id = $user->id;
                $experience->created_by = $user->id;
                $experience->updated_by = $user->id;
                $experience->exact_position = 'not set';
                $experience->experience_in_this_occupation = 0;
                $experience->save(false);

                $trans->commit();

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
                        return $this->redirect(['user-profile/index']);
                    }

                    $model = new SignupForm();
                    $identification = new UserProfile();
                    $education = new JsEducation();
                    $address = new JsAddress();

                    return $this->render('register/register', [
                                'identification' => $identification,
                                'education' => $education,
                                'address' => $address,
                                'model' => $model
                    ]);
                }
            }
        } catch (Exception $exc) {
            $trans->rollBack();
        }

        return $this->render('register/register', [
                    'identification' => $identification,
                    'education' => $education,
                    'address' => $address,
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserProfile model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update UserProfile #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "UserProfile #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update UserProfile #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->user_id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing UserProfile model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing UserProfile model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete() {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
