<?php

namespace frontend\modules\user\controllers;

use common\base\MultiModel;
use frontend\modules\user\models\AccountForm;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

class ProfileController extends Controller {

    /**
     * @return array
     */
    public function actions() {
        return [
            'avatar-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'avatar-delete',
                'on afterSave' => function ($event) {
                    /* @var $file \League\Flysystem\File */
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                    $file->put($img->encode());
                }
            ],
            'avatar-delete' => [
                'class' => DeleteAction::class
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
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex() {
        $accountForm = new AccountForm();
        $accountForm->setUser(Yii::$app->user->identity);

        $model = new MultiModel([
            'models' => [
                'account' => $accountForm,
                'profile' => (Yii::$app->user->can('employer')) ? Yii::$app->user->identity->employerProfile : Yii::$app->user->identity->userProfile
            ]
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $locale = $model->getModel('profile')->locale;
            Yii::$app->session->setFlash('forceUpdateLocale');
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('frontend', 'Your account has been successfully saved', [], $locale)
            ]);
            return $this->refresh();
        }
        return $this->render('index', ['model' => $model]);
    }

    public function actionNotification() {
        $this->layout = 'dashboard';
        $notifications = \common\models\SNotifications::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $notifications,
            'pagination' => ['pageSize' => 10],
        ]);
        return $this->render('notification', [
                    'notifications' => $dataProvider->getModels(),
                    'pagination' => $dataProvider->pagination,
                    'notification_count' => $dataProvider->getTotalCount(),
        ]);
    }

    public function actionOpenNotification() {

        $request = Yii::$app->request;

        $notification_id = $request->post('notification_id'); // Array or selected records primary keys
        $notification = \common\models\SNotifications::findOne($notification_id);
        $notification->is_opened = 1;
        if (!$notification->save(false)) {
            var_dump($notification->errors);
            die;
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionReportJobSeekers($level = 0) {
        $this->layout = 'dashboard';
        $query = \common\models\JsEducation::find()->select('s_education_field.id as field_id, s_education_field.field, s_education_level.id as level_id, s_education_level.`level`, js_education.user_id, js_education.education_field_id, js_education.exact_quali, count(js_education.user_id) as total_user')
                ->leftJoin('s_education_field', 'js_education.education_field_id = s_education_field.id')
                ->leftJoin('s_education_level', 'js_education.education_level_id = s_education_level.id')
                ->groupBy('s_education_field.id')
                ->orderBy(['count(js_education.user_id)' => SORT_DESC]);
        if (isset($level) && intval($level) > 0) {
            $query->where(['s_education_level.id' => $level]);
        }
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
        ]);

        return $this->render('job_seeker_by_education', [
                    'education_levels' => \backend\models\SEducationLevel::find()->asArray()->all(),
                    'selected_level' => $level,
                    'educations' => $query->createCommand()->queryAll(),
                    'pagination' => $dataProvider->pagination,
                    'educations_count' => $dataProvider->getTotalCount(),
        ]);
    }

    public function actionChangePassword() {
        $this->layout = 'dashboard';
        $accountForm = new AccountForm();
        $accountForm->setUser(Yii::$app->user->identity);

        if ($accountForm->load(Yii::$app->request->post()) && $accountForm->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

}
