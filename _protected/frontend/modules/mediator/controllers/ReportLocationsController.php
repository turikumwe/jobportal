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
class ReportLocationsController extends Controller
{
    public function actionExportDatabyDistrict($opportunity=null)
    {
        $searchModel =  new ServiceJobSearch();
        $dataProvider = $searchModel->searchReportLocation(Yii::$app->request->queryParams, $opportunity);
$dataProvider->pagination=false;

        $data = $dataProvider->getModels();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'District')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Number of Advertised')->getStyle('b1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Number of Active')->getStyle('c1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Number of Active')->getStyle('d1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
           if(count($data)>0)
        {
            $counter=2;
            foreach($data as $userprofile)
            {
                 $districtid = \common\models\JsAddress::find()->where(['district_id' => $userprofile['district_id']])->one();

               if (($districtid['district_id'] == 0) || $districtid['district_id'] == 600)  
                {
                     $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'Not Set');
                }
                else
                {
               $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, \backend\models\SDistrict::findone($userprofile->district_id)->district);
               }
                 
                 $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter,$userprofile->totalJobByDistrict($userprofile->district_id));
                 $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter,$userprofile->totalAvailableByDistrict($userprofile->district_id));
                 $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter,$userprofile->totalArchivedByDistrict($userprofile->district_id));
                  
          //$objPHPExcel->getActiveSheet()->setCellValue('e' . $counter, \backend\models\SActions::find()->asArray()->all(), 'pk_action', 'action');
           
        
                  $counter++;
            }
            ob_end_clean();
              header('Content-Type: application/vnd.ms-excel');
        $filename = "Opportunities-Report-by-District.xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
        $objWriter->save('php://output');
        die();
        ob_end_clean();
        }
    }
	
	public function actionIndex($opportunity=null)
    {
             $this->layout='dashboard';
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel =  new ServiceJobSearch();
        $dataProvider = $searchModel->searchReportLocation(Yii::$app->request->queryParams, $opportunity);

        return $this->render('reportList', [
            'type' => 'job',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEvent($opportunity=null)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel = new ServiceEventSearch();
        $dataProvider = $searchModel->searchReportLocation(Yii::$app->request->queryParams, $opportunity);

        return $this->render('reportList', [
        	'type' => 'event',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJob($opportunity=null)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel =  new ServiceJobSearch();
        $dataProvider = $searchModel->searchReportLocation(Yii::$app->request->queryParams, $opportunity);

        return $this->render('reportList', [
        	'type' => 'job',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($district_id=null,$opportunity=null)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel =  new ServiceJobSearch();
        $dataProvider = $searchModel->searchReportLocationbyDistrict(Yii::$app->request->queryParams, $district_id, $opportunity);

        return $this->render('breakdown/reportList', [
            'type' => 'job',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewEvent($district_id=null,$opportunity=null)
    {
        if(! Yii::$app->user->can('mediator')){ throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));} 

        $searchModel =  new ServiceEventSearch();
        $dataProvider = $searchModel->searchReportLocationbyDistrict(Yii::$app->request->queryParams, $district_id, $opportunity);

        return $this->render('breakdown/reportList', [
            'type' => 'event',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
}
