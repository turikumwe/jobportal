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
use backend\models\SDistrict;
use common\models\UserProfile;

/**
 * Default controller for the `mediator Report` module
 */
class ReportEventsStatController extends Controller
{
    
    public function actionExportData($opportunity=null)
    {
         $searchModel = new JsEventApplicationSearch();
        $dataProvider = $searchModel->searchReportEventStat(Yii::$app->request->queryParams, $opportunity);
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
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Male')->getStyle('E1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Female')->getStyle('F1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        if(count($data)>0)
        {
            $counter=2;
            foreach($data as $userprofile)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter,$userprofile->even->event_title);
                 
                 $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter,$userprofile->even->venue);
                 $objPHPExcel->getActiveSheet()->setCellValue('c' . $counter,$userprofile->even->start_date);
                  $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter,$userprofile->even->end_date);
          $objPHPExcel->getActiveSheet()->setCellValue('e' . $counter,$userprofile->numberofGenderApplied(UserProfile::GENDER_MALE, $userprofile->even_id));
          $objPHPExcel->getActiveSheet()->setCellValue('f' . $counter,$userprofile->numberofGenderApplied(UserProfile::GENDER_FEMALE, $userprofile->even_id));
        
        
                  $counter++;
            }
              header('Content-Type: application/vnd.ms-excel');
        $filename = "Report-Event-stat.xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
        $objWriter->save('php://output');
        die();
        }
    }
	
	public function actionIndex($opportunity=null)
    {
             $this->layout='dashboard';
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel = new JsEventApplicationSearch();
        $dataProvider = $searchModel->searchReportEventStat(Yii::$app->request->queryParams, $opportunity);

        return $this->render('reportList', [
            'type' => 'event',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewEvent($event_id,$opportunity=null)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel = new JsEventApplicationSearch();
        $dataProvider = $searchModel->searchReportEventStatBreakdown(Yii::$app->request->queryParams, $event_id, $opportunity);

        return $this->render('breakdown/reportList', [
            'type' => 'event',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
