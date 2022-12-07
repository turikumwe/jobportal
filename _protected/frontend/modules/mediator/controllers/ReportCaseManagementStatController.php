<?php

namespace frontend\modules\mediator\controllers;

use frontend\modules\jobseeker\models\search\JsCaseManagement as JsCaseManagementSearch;
use frontend\modules\jobseeker\models\search\JsJobApplicationSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use common\models\UserProfile;
use backend\models\SDistrict;
use Yii;

/**
 * Default controller for the `mediator Report` module
 */
class ReportCaseManagementStatController extends Controller {

    public function actionExportData() {
        $searchModel = new JsCaseManagementSearch();
        $dataProvider = $searchModel->searchReportStat(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        $data = $dataProvider->getModels();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Service')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Male')->getStyle('B1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Female')->getStyle('C1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Total')->getStyle('D1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        if (count($data) > 0) {
            $counter = 2;
            foreach ($data as $userprofile) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $userprofile->services->name);

                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $userprofile->numberofGender(UserProfile::GENDER_MALE, $userprofile->given_service));
                $objPHPExcel->getActiveSheet()->setCellValue('c' . $counter, $userprofile->numberofGender(UserProfile::GENDER_FEMALE, $userprofile->given_service));
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $userprofile->numberofGenderTotal($userprofile->given_service));
                $counter++;
            }
            header('Content-Type: application/vnd.ms-excel');
            $filename = "Report-Case-management-stat.xls";
            header('Content-Disposition: attachment;filename=' . $filename . ' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
            $objWriter->save('php://output');
            die();
        }
    }

    public function actionIndex() {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('mediator')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $searchModel = new JsCaseManagementSearch();
        $dataProvider = $searchModel->searchReportStat(Yii::$app->request->queryParams);

        return $this->render('reportList', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($service) {
        if (!Yii::$app->user->can('mediator')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $searchModel = new JsCaseManagementSearch();
        $dataProvider = $searchModel->searchReportStatBreakdown(Yii::$app->request->queryParams, $service);

        return $this->render('breakdown/reportList', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
