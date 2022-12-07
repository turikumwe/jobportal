<?php

namespace frontend\modules\mediator\controllers;

use frontend\modules\service\models\search\ServiceJobSearch;
use frontend\modules\service\models\search\ServiceEventSearch;
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
class ReportEconomicSectorController extends Controller {

    public function actionExportData() {
        $searchModel = new ServiceJobSearch();
        $dataProvider = $searchModel->searchReportEconomicSector(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;

        $data = $dataProvider->getModels();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Economic Sector')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Number Of Advertised')->getStyle('b1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Number Of Active')->getStyle('C1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Number Of Active')->getStyle('D1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');

        if (count($data) > 0) {
            $counter = 2;
            foreach ($data as $userprofile) {

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $userprofile->economicSector->occupation);

                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $userprofile->totalJobByEconomicSector($userprofile->economic_sector_id));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $userprofile->totalAvailableByEconomicSector($userprofile->economic_sector_id));
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $userprofile->totalArchivedByEconomicSector($userprofile->economic_sector_id));

                //$objPHPExcel->getActiveSheet()->setCellValue('e' . $counter, \backend\models\SActions::find()->asArray()->all(), 'pk_action', 'action');


                $counter++;
            }
            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            $filename = "Economic-sector-report.xls";
            header('Content-Disposition: attachment;filename=' . $filename . ' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
            $objWriter->save('php://output');
            die();
            ob_end_clean();
        }
    }

    public function actionIndex() {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('mediator')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $searchModel = new ServiceJobSearch();
        $dataProvider = $searchModel->searchReportEconomicSector(Yii::$app->request->queryParams);

        return $this->render('reportList', [
                    'type' => 'job',
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEvent($opportunity = null, $action_id = null) {
        if (!Yii::$app->user->can('mediator')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $searchModel = new ServiceEventSearch();
        $dataProvider = $searchModel->searchReportEconomicSector(Yii::$app->request->queryParams, $opportunity, $action_id);

        return $this->render('reportList', [
                    'type' => 'event',
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJob($opportunity = null, $action_id = null) {
        if (!Yii::$app->user->can('mediator')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $searchModel = new ServiceJobSearch();
        $dataProvider = $searchModel->searchReportEconomicSector(Yii::$app->request->queryParams, $opportunity, $action_id);

        return $this->render('reportList', [
                    'type' => 'job',
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($economic_sector_id = null, $opportunity = null) {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('mediator')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $searchModel = new ServiceJobSearch();
        $dataProvider = $searchModel->searchReportEconomicSectorBreakdown(Yii::$app->request->queryParams, $economic_sector_id, $opportunity);

        return $this->render('breakdown/reportList', [
                    'type' => 'job',
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewEvent($economic_sector_id = null, $opportunity) {
        if (!Yii::$app->user->can('mediator')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $searchModel = new ServiceEventSearch();
        $dataProvider = $searchModel->searchReportEconomicSectorBreakdown(Yii::$app->request->queryParams, $economic_sector_id, $opportunity);

        return $this->render('breakdown/reportList', [
                    'type' => 'event',
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
