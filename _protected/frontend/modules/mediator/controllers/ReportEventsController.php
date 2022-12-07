<?php

namespace frontend\modules\mediator\controllers;

use frontend\modules\jobseeker\models\search\JsEventApplicationSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;
use common\models\UserProfile;


/**
 * Default controller for the `mediator Report` module
 */
class ReportEventsController extends Controller {

     public function actionExportData($opportunity=null)
    {
         $searchModel = new JsEventApplicationSearch();
        $dataProvider = $searchModel->searchReportEvent(Yii::$app->request->queryParams, $opportunity);
$dataProvider->pagination=false;
        $data = $dataProvider->getModels();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Event title')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Event Venue')->getStyle('B1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Event start date')->getStyle('C1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Event end date')->getStyle('D1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('e1', 'Male')->getStyle('E1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('f1', 'Female')->getStyle('F1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        
        
        if(count($data)>0)
        {
            $counter=2;
            foreach($data as $userprofile)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $userprofile->even->event_title);
                 
                 $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $userprofile->even->venue);
                 $objPHPExcel->getActiveSheet()->setCellValue('c' . $counter, $userprofile->even->start_date);
                  $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $userprofile->even->end_date);
         $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $userprofile->numberofGenderApplied(UserProfile::GENDER_MALE, $userprofile->even_id));
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $userprofile->numberofGenderApplied(UserProfile::GENDER_FEMALE, $userprofile->even_id));
       
                  $counter++;
            }
            ob_end_clean();
              header('Content-Type: application/vnd.ms-excel');
        $filename = "Event-List-Report.xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
        $objWriter->save('php://output');
        die();
        ob_end_clean();
        }
    }

    public function actionIndex($opportunity = null) {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('mediator')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $searchModel = new JsEventApplicationSearch();
        $dataProvider = $searchModel->searchReportEvent(Yii::$app->request->queryParams, $opportunity);

        return $this->render('reportList', [
                    'type' => 'event',
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
