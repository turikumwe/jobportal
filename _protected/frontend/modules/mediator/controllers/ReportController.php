<?php

namespace frontend\modules\mediator\controllers;

use frontend\modules\jobseeker\models\search\JsEventApplicationSearch;
use frontend\modules\jobseeker\models\search\JsJobApplicationSearch;
use frontend\modules\employer\models\search\EmplEmployerSearch;
use frontend\modules\jobseeker\models\search\UserProfileSearch;
use common\models\User;
use yii\web\NotFoundHttpException;
use common\models\UserProfile;
use yii\filters\VerbFilter;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;
use yii\db\ActiveRecord;
use kartik\export\ExportMenu;
use arturoliveira\ExcelView;
use kartik\grid\GridView;

/* * use kartik\export\ExportMenu;
 * Default controller for the `mediator Report` module
 */

class ReportController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionListreports() {
        $this->layout = 'dashboard';
        return $this->render('listreports');
    }

    public function actionExportData() {
        $conn = \Yii::$app->db;
        $query = 'SELECT COUNT(user_profile.locale) AS stat, s_district.district, s_gender.gender, s_education_field.field, s_education_level.`level` FROM user_profile '
                . 'INNER JOIN js_address ON user_profile.user_id = js_address.user_id '
                . 'INNER JOIN js_education ON js_address.user_id = js_education.user_id '
                . 'INNER JOIN s_district ON js_address.district_id = s_district.id '
                . 'INNER JOIN s_gender ON user_profile.gender = s_gender.id '
                . 'INNER JOIN s_education_field ON js_education.education_field_id = s_education_field.id '
                . 'INNER JOIN s_education_level ON js_education.education_level_id = s_education_level.id '
                . 'GROUP BY js_address.district_id, s_gender.id, s_education_level.`level`, s_education_field.field '
                . 'ORDER BY s_gender.id, s_district.district, s_education_field.field, s_education_level.`level`; ';

        $query_result = $conn->createCommand($query)->queryAll();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'District')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Gender')->getStyle('b1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');

        $objPHPExcel->getActiveSheet()->setCellValue('c1', 'Education Level')->getStyle('c1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');

        $objPHPExcel->getActiveSheet()->setCellValue('d1', 'Education Field')->getStyle('d1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');

        $objPHPExcel->getActiveSheet()->setCellValue('e1', 'Total')->getStyle('e1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');

        if (count($query_result) > 0) {
            $counter = 2;
            foreach ($query_result as $userprofile) {

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $userprofile['district']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $userprofile['gender']);
                $objPHPExcel->getActiveSheet()->setCellValue('c' . $counter, $userprofile['level']);
                $objPHPExcel->getActiveSheet()->setCellValue('d' . $counter, $userprofile['field']);
                $objPHPExcel->getActiveSheet()->setCellValue('e' . $counter, $userprofile['stat']);

                $counter++;
            }
            header('Content-Type: application/vnd.ms-excel');
            $filename = "Statistic-report.xls";
            header('Content-Disposition: attachment;filename=' . $filename . ' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
            $objWriter->save('php://output');
            die();
        }
    }

    public function actionStatistics() {
        $this->layout = 'dashboard';

        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-jobseeker/reportLocation', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex() {
        $this->layout = 'dashboard';
        $user_roles = \backend\modules\rbac\models\RbacAuthAssignment::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        $roles = array();
        if (count($user_roles) > 0) {
            foreach ($user_roles as $role) {
                array_push($roles, $role->item_name);
            }
        }
        $reports = \common\models\SReportList::find()->all();

        return $this->render('listreports', [
                    'reports' => $reports,
                    'user_roles' => $roles,
        ]);
    }

    /*     * ************************************ statistic Jobseeker ***************************************** */

    public function actionJobseekerStatisticLocation() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-jobseeker/reportLocation', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJobseekerStatisticOccupation() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-jobseeker/reportOccupation', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJobseekerStatisticIndustries() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-jobseeker/reportIndustries', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJobseekerStatisticPhysicalDisability() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-jobseeker/reportDisability', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /*     * ******************************************** Employer ********************************************* */

    public function actionEmployerByLocation() {
        $searchModel = new EmplEmployerSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-employer/reportLocation', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEmployerByIndustries() {
        $searchModel = new EmplEmployerSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-employer/reportIndustries', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEmployerByList() {
        $searchModel = new EmplEmployerSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-employer/reportDisability', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /*     * ******************************************** Employer ********************************************* */

    public function actionCaseManagementByLocation() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-casemanagement/reportDisability', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCaseManagementByIndustries() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-casemanagement/reportDisability', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCaseManagementByList() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('statistics-casemanagement/reportDisability', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /*     * ******************************************** Apportunities ********************************************* */

    public function actionJobApplied($opportunity) {
        $searchModel = new JsJobApplicationSearch();
        $dataProvider = $searchModel->searchReport($opportunity, Yii::$app->request->queryParams);

        return $this->render('statistics-opportunity/reportJob', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEventApplied($opportunity) {
        $searchModel = new JsEventApplicationSearch();
        $dataProvider = $searchModel->searchReport($opportunity, Yii::$app->request->queryParams);

        return $this->render('statistics-opportunity/reportEvent', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEventBreakdown($expertise, $opportunity) {
        $searchModel = new JsEventApplicationSearch();
        $dataProvider = $searchModel->searchReportBreakdown($expertise, $opportunity, Yii::$app->request->queryParams);

        return $this->render('statistics-opportunity/reportEventBreakdown', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJobBreakdown($job, $opportunity) {
        $searchModel = new JsJobApplicationSearch();
        $dataProvider = $searchModel->searchReportBreakdown($job, $opportunity, Yii::$app->request->queryParams);

        return $this->render('statistics-opportunity/reportJobBreakdown', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
