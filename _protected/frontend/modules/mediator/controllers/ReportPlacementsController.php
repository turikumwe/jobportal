<?php

namespace frontend\modules\mediator\controllers;

use frontend\modules\jobseeker\models\search\JsJobApplicationSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;

/**
 * Default controller for the `mediator Report` module
 */
class ReportPlacementsController extends Controller {

    public function actionExportData($opportunity = null) {
        $searchModel = new JsJobApplicationSearch();
        $dataProvider = $searchModel->searchReportPlacement(Yii::$app->request->queryParams, $opportunity);
        $dataProvider->pagination = false;
        $data = $dataProvider->getModels();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Company')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Job Application')->getStyle('b1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Gender')->getStyle('c1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Phone')->getStyle('d1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Application Date ')->getStyle('e1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Start date')->getStyle('f1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'End date')->getStyle('g1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Opportunity')->getStyle('h1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'District')->getStyle('i1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');

        $objPHPExcel->getActiveSheet()->setCellValue('j1', 'Sector')->getStyle('j1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('k1', 'Country')->getStyle('k1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('l1', 'Education ')->getStyle('l1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('m1', 'Placed')->getStyle('m1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        if (count($data) > 0) {
            $counter = 2;
            foreach ($data as $userprofile) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $userprofile->job->employer);
                if (!empty($userprofile->user->userProfile->fullName)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $userprofile->user->userProfile->fullName);
                }
                if (!empty($userprofile->user->userProfile->gender)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('c' . $counter, ($userprofile->user->userProfile->gender == 1) ? 'Male' : 'Female');
                }
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $userprofile->user->phone);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, date('Y-m-d', strtotime($userprofile->application_date)));
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $userprofile->job->posting_date);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $userprofile->job->closure_date);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $userprofile->opportunity->name);
                if (isset($userprofile->user->userProfile->jsAddress->district->district)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, $userprofile->user->userProfile->jsAddress->district->district);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, 'Not Set');
                }
                if (!empty($userprofile->user->userProfile->jsAddress->geosector->sector)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, $userprofile->user->userProfile->jsAddress->geosector->sector ? $userprofile->user->userProfile->jsAddress->geosector->sector : 'Null');
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, 'Not Set');
                }
                if (!empty($userprofile->user->userProfile->jsAddress->country->cc_description)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, ($userprofile->user->userProfile->jsAddress->country->cc_description));
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, 'Not Set');
                }
                if (!empty($userprofile->user->jsEducation->educationLevel->level)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('l' . $counter, ($userprofile->user->jsEducation->educationLevel->level) ? $userprofile->user->jsEducation->educationLevel->level : '-');
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('l' . $counter, 'Not Set');
                }
                $objPHPExcel->getActiveSheet()->setCellValue('m' . $counter, ($userprofile->placement == 1) ? 'Yes' : 'No');

                $counter++;
            }
            header('Content-Type: application/vnd.ms-excel');
            $filename = "Placement-Report.xls";
            header('Content-Disposition: attachment;filename=' . $filename . ' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
            $objWriter->save('php://output');
            die();
        }
    }

    public function actionIndex($opportunity = null) {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('mediator')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $searchModel = new JsJobApplicationSearch();
        $dataProvider = $searchModel->searchReportPlacement(Yii::$app->request->queryParams, $opportunity);

        return $this->render('reportList', [
                    'type' => 'job',
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
