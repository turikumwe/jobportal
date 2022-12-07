<?php

namespace frontend\modules\service\controllers;

use frontend\modules\service\models\search\ServiceEventSearch;
use yii\web\NotFoundHttpException;
use common\models\JsEventApplication;
use common\models\ServiceEventSharing;
use backend\models\SEventCategory;
use common\models\ServiceEvent;
use common\models\SOpportunity;
use backend\models\SDistrict;
use common\models\JsSummary;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use \common\models\User;
use \common\models\JsSavedEvent;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
/**
 * ServiceEventController implements the CRUD actions for ServiceEvent model.
 */
class ServiceEventController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex($opportunity = null, $title = null, $location = null, $sort = 'N') {
        $searchModel = new ServiceEventSearch();
        $opportunities = $searchModel->search(Yii::$app->request->queryParams, $opportunity, $title, $location, $sort);

        $districts = SDistrict::find()->all();
        $sorting = array(
            'N' => 'Newest',
            'O' => 'Oldest'
        );
        return $this->render('index', [
                    'categories' => ArrayHelper::map(SEventCategory::find()->all(), 'id', 'category'),
                    'shared' => ServiceEventSharing::find()->shared()->type($opportunity)->freshFirst()->all(),
                    'saved' => ServiceEventSharing::find()->saved()->type($opportunity)->freshFirst()->all(),
                    'applied' => JsEventApplication::find()->applied()->type($opportunity)->freshFirst()->all(),
                    'districts' => ArrayHelper::map($districts, 'id', 'district'),
                    'profile' => User::findOne(Yii::$app->user->id),
                    'location' => $location,
                    'sorting' => $sorting,
                    'selected_sorting' => $sort,
                    'apply' => new JsEventApplication(),
                    'share' => new ServiceEventSharing(),
                    'event_count' => $opportunities->getTotalCount(),
                    'events' => $opportunities->getModels(),
                    'pagination' => $opportunities->pagination,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionEvent($opportunity = null, $title = null, $location = null, $sort = 'N') {
        $searchModel = new ServiceEventSearch();
        $opportunities = $searchModel->searchEvents(Yii::$app->request->queryParams, $opportunity, $title, $location, $sort);

        $districts = SDistrict::find()->all();
        $sorting = array(
            'N' => 'Newest',
            'O' => 'Oldest'
        );
        return $this->render('events', [
                    'categories' => ArrayHelper::map(SEventCategory::find()->all(), 'id', 'category'),
                    'shared' => ServiceEventSharing::find()->shared()->type($opportunity)->freshFirst()->all(),
                    'saved' => ServiceEventSharing::find()->saved()->type($opportunity)->freshFirst()->all(),
                    'applied' => JsEventApplication::find()->applied()->type($opportunity)->freshFirst()->all(),
                    'districts' => ArrayHelper::map($districts, 'id', 'district'),
                    'profile' => User::findOne(Yii::$app->user->id),
                    'location' => $location,
                    'sorting' => $sorting,
                    'selected_sorting' => $sort,
                    'apply' => new JsEventApplication(),
                    'share' => new ServiceEventSharing(),
                    'event_count' => $opportunities->getTotalCount(),
                    'events' => $opportunities->getModels(),
                    'pagination' => $opportunities->pagination,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionMyEvents($opportunity = null, $type = null, $search = 0, $title = null) {
        $this->layout = 'dashboard';

        $searchModel = new ServiceEventSearch();
        $opportunities = $searchModel->searchAll(Yii::$app->request->queryParams, $opportunity, 2, $search, $title);

        return $this->render('my_events', [
                    'opportunities' => $opportunities->getModels(),
                    'pagination' => $opportunities->pagination,
                    'selected_type' => $type,
                    'opportinities' => SOpportunity::find()->firstType()->all(),
                    'events_count' => $opportunities->getTotalCount(),
        ]);
    }

    public function actionMyTraining($opportunity = null, $type = null, $search = 0, $title = null) {
        $this->layout = 'dashboard';

        $searchModel = new ServiceEventSearch();
        $opportunities = $searchModel->searchAll(Yii::$app->request->queryParams, $opportunity, 1, $search, $title);

        return $this->render('my_training', [
                    'opportunities' => $opportunities->getModels(),
                    'pagination' => $opportunities->pagination,
                    'selected_type' => $type,
                    'opportinities' => SOpportunity::find()->firstType()->all(),
                    'events_count' => $opportunities->getTotalCount(),
        ]);
    }

    function actionBulkEventStatus() {
        $request = Yii::$app->request;
        $pks = $request->post('selected_events'); // Array or selected records primary keys

        $selected_status = $request->post('selected_status');

        foreach ($pks as $pk) {

            $model = ServiceEvent::findOne($pk);
            $model->action_id = intval($selected_status);
            if (!$model->save(false)) {
                var_dump($model->errors);
                die;
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPostOpportunity() {
        
        if (\common\models\User::isFromEmployer(Yii::$app->user->identity->id)) {

            $employer = User::findOne(Yii::$app->user->identity->id);
            if ($employer->employerProfile->is_verified == 0) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        }
        Yii::$app->db->schema->refresh();
        $this->layout = 'dashboard';
        $event = new ServiceEvent();
        return $this->render('post/index', [
                    'model' => $event,
                    'is_update' => false,
                    'url' => '/service/service-event/create',
                    'profile' => User::findOne(Yii::$app->user->id),
                    'opportunities' => SOpportunity::find()->secondType()->orderBy('name desc')->all()
        ]);
    }

    //event
    public function actionPostEvent() {
        if (\common\models\User::isFromEmployer(Yii::$app->user->identity->id)) {

            $employer = User::findOne(Yii::$app->user->identity->id);
            if ($employer->employerProfile->is_verified == 0) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        }
        $this->layout = 'dashboard';
        $event = new ServiceEvent();
        return $this->render('post/indexevent', [
                    'model' => $event,
                    'is_update' => false,
                    'url' => '/service/service-event/create-event',
                    'profile' => User::findOne(Yii::$app->user->id),
                    'opportunities' => SOpportunity::find()->secondType()->all()
        ]);
    }

    public function actionUpdateOpportunity($id) {
        $this->layout = 'dashboard';
        return $this->render('post/index', [
                    'model' => $this->findModel($id),
                    'is_update' => true,
                    'url' => '/service/service-event/update?id=' . $id,
                    'profile' => User::findOne(Yii::$app->user->id),
                    'opportunities' => SOpportunity::find()->secondType()->all()
        ]);
    }

    public function actionUpdateEvent($id) {
        $this->layout = 'dashboard';
        return $this->render('post/indexevent', [
                    'model' => $this->findModel($id),
                    'is_update' => true,
                    'url' => '/service/service-event/update-event-opportunity?id=' . $id,
                    'profile' => User::findOne(Yii::$app->user->id),
                    'opportunities' => SOpportunity::find()->secondType()->all()
        ]);
    }

    public function actionSaveEvent() {
        
        $request = Yii::$app->request;

        $saved_event = new JsSavedEvent();
        if ($saved_event->load($request->post())) {
            if ($saved_event->save(false)) {
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                var_dump($saved_event->errors);
                die;
            }
        }
    }

    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "ServiceJob #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
                        'apply' => new JsEventApplication(),
                        'jobseeker' => User::findOne(Yii::$app->user->id),
                        'mediator' => User::findOne(Yii::$app->user->id),
                        'employer' => User::findOne(Yii::$app->user->id),
                        'summary' => JsSummary::find()->myProfile()->one()
            ]);
        }
    }

    /**
     * Creates a new ServiceEvent model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->layout = 'dashboard';
        $request = Yii::$app->request;
        $model = new ServiceEvent();
        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new ServiceEvent",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new ServiceEvent",
                    'content' => '<span class="text-success">Create ServiceEvent success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new ServiceEvent",
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
            $model->doc_path = UploadedFile::getInstance($model, 'docFile');

            $filename = str_replace(" ", "", $model->doc_path);
            if (strlen($filename) > 0) {
                $model->doc_path->saveAs('storage/source/1/' . $filename);
                $model->doc_path = $filename;
            }

            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['my-trainings']);
            } else {
                return $this->render('post/index', [
                            'model' => $model,
                            'is_update' => false,
                            'url' => '/service/service-event/create',
                            'profile' => User::findOne(Yii::$app->user->id),
                            'opportunities' => SOpportunity::find()->secondType()->orderBy('name desc')->all()
                ]);
            }
        }
    }

    public function actionCreateEvent() {
        $this->layout = 'dashboard';
        $request = Yii::$app->request;
        $model = new ServiceEvent();
        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new ServiceEvent",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new ServiceEvent",
                    'content' => '<span class="text-success">Create ServiceEvent success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new ServiceEvent",
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

            $model->doc_path = UploadedFile::getInstance($model, 'docFile');

            $filename = str_replace(" ", "", $model->doc_path);
            if (strlen($filename) > 0) {
                $model->doc_path->saveAs('storage/source/1/' . $filename);
                $model->doc_path = $filename;
            }

            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['my-events']);
            } else {
                return $this->render('post/indexevent', [
                            'model' => $model,
                            'is_update' => false,
                            'url' => '/service/service-event/create',
                            'profile' => User::findOne(Yii::$app->user->id),
                            'opportunities' => SOpportunity::find()->secondType()->orderBy('name desc')->all()
                ]);
            }
        }
    }

    /**
     * Updates an existing ServiceEvent model.
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
                    'title' => "Update ServiceEvent #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "ServiceEvent #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update ServiceEvent #" . $id,
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
                return $this->redirect('my-training');
            } else {
                return $this->render('post/index', [
                            'model' => $model,
                            'is_update' => true,
                            'url' => '/service/service-event/create',
                            'profile' => User::findOne(Yii::$app->user->id),
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionUpdateEventOpportunity($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update ServiceEvent #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "ServiceEvent #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update ServiceEvent #" . $id,
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
                return $this->redirect('my-events');
            } else {
                return $this->render('post/indexevent', [
                            'model' => $model,
                            'is_update' => true,
                            'url' => '/service/service-event/create',
                            'profile' => User::findOne(Yii::$app->user->id),
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing ServiceEvent model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        $this->findModel($id)->deleteWithRelated();

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
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Delete multiple existing ServiceEvent model.
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
     * Finds the ServiceEvent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ServiceEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ServiceEvent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
