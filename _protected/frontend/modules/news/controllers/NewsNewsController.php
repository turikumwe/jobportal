<?php

namespace frontend\modules\news\controllers;

use Yii;
use common\models\NewsNews;
use frontend\modules\news\models\NewsNewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use common\models\User;
use common\commands\AddToTimelineCommand;
use yii\web\ForbiddenHttpException;

/**
 * NewsNewsController implements the CRUD actions for NewsNews model.
 */
class NewsNewsController extends Controller {

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

    /**
     * Lists all NewsNews models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new NewsNewsSearch();
        $dataProvider = $searchModel->searchPublished(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdmin($title = null) {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('RDB')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $searchModel = new NewsNewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $title);

        return $this->render('admin', [
                    'searchModel' => $searchModel,
                    'news' => $dataProvider->getModels(),
                    'pagination' => $dataProvider->pagination,
                    'news_count' => $dataProvider->getTotalCount(),
        ]);
    }

    /**
     * Displays a single NewsNews model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "NewsNews #" . $id,
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

    public function actionPostNews() {
        Yii::$app->db->schema->refresh();
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('RDB')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $news = new NewsNews();
        return $this->render('post/news', [
                    'model' => $news,
                    'is_update' => false,
                    'url' => '/news/news-news/create',
        ]);
    }

    /**
     * Creates a new NewsNews model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new NewsNews();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new NewsNews",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $model->link = 'http://' . $model->link;
                if (!$model->save())
                    var_dump($model->errors);
                else {
                    $user = New User();
                    // $role = 'manager';
                    // $user->afterSignup($role);
                    $this->refresh();

                    // echo $this->getPublicIdentity(); die;

                    Yii::$app->commandBus->handle(new AddToTimelineCommand([
                                'category' => 'manager',
                                'event' => 'news',
                                'data' => [
                                    'public_identity' => $user->getPublicIdentity(),
                                    'user_id' => $user->getId(),
                                    'created_at' => $user->created_at
                                ]
                    ]));
                }

                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new NewsNews",
                    'content' => '<span class="text-success">Create NewsNews success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new NewsNews",
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
                return $this->redirect(['admin']);
            } else {
                return $this->render('post/news', [
                            'model' => $model,
                            'is_update' => false,
                            'url' => '/news/news-news/create',
                ]);
            }
        }
    }

    /**
     * Updates an existing NewsNews model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('RDB')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update NewsNews #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $model->link = 'http://' . $model->link;
                if (!$model->save())
                    var_dump($model->errors);
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "NewsNews #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update NewsNews #" . $id,
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
                return $this->redirect(['admin']);
            } else {
                return $this->render('post/news', [
                            'model' => $model,
                            'is_update' => true,
                            'url' => '/news/news-news/update?id=' . $id,
                ]);
            }
        }
    }

    /**
     * Delete an existing NewsNews model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        if (!Yii::$app->user->can('RDB')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            // Yii::$app->response->format = Response::FORMAT_JSON;
            // return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
            return $this->redirect(['admin']);
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['admin']);
        }
    }

    /**
     * Delete multiple existing NewsNews model.
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

    function actionBulkStatus() {
        $request = Yii::$app->request;
        $pks = $request->post('selected_news'); // Array or selected records primary keys

        $selected_status = $request->post('selected_status');

        foreach ($pks as $pk) {

            $model = NewsNews::findOne($pk);
            $model->action_id = intval($selected_status);
            if (!$model->save(false)) {
                var_dump($model->errors);
                die;
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the NewsNews model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NewsNews the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = NewsNews::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
