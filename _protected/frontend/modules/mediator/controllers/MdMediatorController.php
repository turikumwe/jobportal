<?php

namespace frontend\modules\mediator\controllers;

use frontend\modules\mediator\models\search\MdMediatorSearch;
use frontend\modules\user\models\AccountForm;
use frontend\modules\jobseeker\models\search\UserProfileSearch;
use yii\web\NotFoundHttpException;
use common\models\MdMediator;
use yii\filters\VerbFilter;
use \common\models\User;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;
use common\models\UserProfile;
use frontend\modules\mediator\models\search\MdEmployeesSearch;
use yii\web\ForbiddenHttpException;

/**
 * MdMediatorController implements the CRUD actions for MdMediator model.
 */
class MdMediatorController extends Controller {

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
     * Lists all MdMediator models.
     * @return mixed
     */
    public function actionExportData($opportunity = null) {
        $searchModel = new MdMediatorSearch();
        $dataProvider = $searchModel->searchAdmin(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;

        $data = $dataProvider->getModels();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Registration Authority')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Registration Number')->getStyle('b1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Mediator Institution name')->getStyle('c1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Mediator Type')->getStyle('d1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Opening Date')->getStyle('E1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Ownership')->getStyle('F1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');

        if (count($data) > 0) {
            $counter = 2;
            foreach ($data as $userprofile) {

                if (isset($userprofile->registration_authority_id)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, \common\models\SRegistrationauthority::findOne($userprofile->registration_authority_id)->registrationauthority);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $userprofile->registration_number);
                $objPHPExcel->getActiveSheet()->setCellValue('c' . $counter, $userprofile->madiator_name);
                if (isset($userprofile->mediator_type_id)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, \backend\models\SMediatorType::findOne($userprofile->mediator_type_id)->mediator_type);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $userprofile->opening_date);
                if (isset($userprofile->ownership_id)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, \backend\models\SOwnership::findOne($userprofile->ownership_id)->ownership);
                }


                $counter++;
            }
            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            $filename = "List_of_Mediators.xls";
            header('Content-Disposition: attachment;filename=' . $filename . ' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
            $objWriter->save('php://output');
            die();
            ob_end_clean();
        }
    }

    public function actionIndex($idOtherProfile = null) {
        $this->layout = 'dashboard';

        $searchModel = new \frontend\modules\service\models\search\ServiceJobSearch();

        $published = $searchModel->searchAll(Yii::$app->request->queryParams, null, null, 0);

        //User from Mediation center
        if (Yii::$app->user->can('mediator')) {
            $user_ids_from_same_mediator = User::getUserIdsFromSameMediator();
            if (count($user_ids_from_same_mediator) > 0) {
                $published->query->andWhere(['in', 'created_by', $user_ids_from_same_mediator]);
            }
        }
        $event = new \frontend\modules\service\models\search\ServiceEventSearch();
        $events = $event->searchAll(Yii::$app->request->queryParams, null, null, 0, null);

        $user = User::findOne(Yii::$app->user->id);
        $mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;
        $users = \common\models\UserProfile::getUsersByMediator($mediator->id);

        return $this->render('index', [
                    'published_jobs' => $published->getTotalCount(),
                    'published_events' => $events->getTotalCount(),
                    'total_jobseekers' => count($users),
        ]);
    }

    public function actionUserProfile($idOtherProfile = null) {
        $this->layout = 'dashboard';
        $accountForm = new AccountForm();
        $accountForm->setUser(Yii::$app->user->identity);

        $user_id = is_null($idOtherProfile) ? Yii::$app->user->id : $idOtherProfile;

        if ($accountForm->load(Yii::$app->request->post()) && $accountForm->save()) {
            return $this->refresh();
        }

        $user = User::findOne($user_id);
        $user_person = \common\models\CommonPerson::findOne(['created_by' => Yii::$app->user->id]);

        return $this->render('user_profile', [
                    'mediator' => !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator,
                    'account' => $accountForm,
                    'account_person' => $user_person,
                    'idOtherProfile' => $user_id,
                    'user' => $user
        ]);
    }

    /**
     * Displays a single MdMediator model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "MdMediator #" . $id,
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
     * Creates a new MdMediator model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new MdMediator();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new MdMediator",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new MdMediator",
                    'content' => '<span class="text-success">Create MdMediator success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new MdMediator",
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
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionJobSeeker($name = null) {
        $this->layout = 'dashboard';

        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchResidence(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        $user = User::findOne(Yii::$app->user->id);
        $mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;
        $users = UserProfile::getUsersByMediator($mediator->id);
        $user_ids = array();
        if (count($users) > 0) {
            foreach ($users as $user) {
                array_push($user_ids, $user['id']);
            }
        }

        $dataProvider->query->andWhere(['in', 'user_profile.user_id', $user_ids]);

        if (isset($name)) {
            $dataProvider->query->andWhere(['like', 'CONCAT(user_profile.lastname,user_profile.firstname)', '%' . htmlspecialchars($name) . '%', false]);
        }
        $dataProvider->query->orderBy(['lastname' => SORT_ASC]);

        return $this->render('job_seeker', [
                    'searchModel' => $searchModel,
                    'applicants' => $dataProvider->getModels(),
                    'applicant_count' => $dataProvider->getTotalCount(),
                    'pagination' => $dataProvider->pagination,
        ]);
    }

    public function actionMediatorUsers($name = null) {
        if (!Yii::$app->user->can('mediator_admin')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $this->layout = 'dashboard';
        $searchModel = new MdEmployeesSearch();
        $user = User::findOne(Yii::$app->user->id);
        $user_mediator = !is_null($user->mediatorProfile) ? $user->mediatorProfile : $user->mediatorEmployee->mediator;

        if (isset($user_mediator)) {
            $dataProvider = $searchModel->searchByMediator(Yii::$app->request->queryParams, $user_mediator->id, $name);
        }
        $dataProvider->pagination->pageSize = 10;
        return $this->render('mediator_users', [
                    'searchModel' => $searchModel,
                    'mediator_employees' => $dataProvider->getModels(),
                    'mediator_employees_count' => $dataProvider->getTotalCount(),
                    'dataProvider' => $dataProvider,
                    'pagination' => $dataProvider->pagination,
        ]);
    }

    public function actionAdmin() {
        $this->layout = 'dashboard';
        $searchModel = new MdMediatorSearch();
        $dataProvider = $searchModel->searchAdmin(Yii::$app->request->queryParams);

        return $this->render('admin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing MdMediator model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate() {
        $request = Yii::$app->request;
        $model = Yii::$app->user->identity->mediatorProfile;

        if ($model->load($request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('frontend', 'Your account has been successfully saved', [], '')
            ]);
            return $this->redirect('/mediator/md-mediator');
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Delete an existing MdMediator model.
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
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing MdMediator model.
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
     * Finds the MdMediator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MdMediator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MdMediator::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStatus() {
        $request = Yii::$app->request;
        $user_id = $request->post('user_id');
        $status = $request->post('action');
        $user = User::findOne($user_id);
        if (isset($user)) {
            $user->status = $status;
            $user->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionHideAndShow($variable, $column) {
        $model = Yii::$app->user->identity->mediatorProfile;
        $model->$column = $variable;
        if ($model->save()) {
            return true;
        }
    }

}
