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
use yii\helpers\ArrayHelper;
use backend\models\SDistrict;
use frontend\modules\employer\models\search\EmplAddressSearch;
use frontend\modules\jobseeker\models\search\EmplEconomicSectorSearch;
use Yii;
use yii\db\ActiveRecord;

/**
 * Default controller for the `mediator Report` module
 */
class ReportEmployerController extends Controller {

    public function actionExportDatabyDistrict() {
        $searchModel = new EmplAddressSearch();
        $dataProvider = $searchModel->searchEmployersReport(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        $data = $dataProvider->getModels();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'District')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        ;
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Number')->getStyle('b1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        ;

        if (count($data) > 0) {
            $counter = 2;
            foreach ($data as $userprofile) {
                $districtid = \common\models\JsAddress::find()->where(['district_id' => $userprofile['district_id']])->one();

                if (($districtid['district_id'] == 0) || $districtid['district_id'] == 600) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'Not Set');
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, SDistrict::findone($userprofile->district_id)->district);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $userprofile->totalEmployersByDistrict($userprofile->district_id));
                $counter++;
            }
            header('Content-Type: application/vnd.ms-excel');
            $filename = "Report-Employer-by-District.xls";
            header('Content-Disposition: attachment;filename=' . $filename . ' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
            $objWriter->save('php://output');
            die();
        }
    }

    public function actionExportData() {
        $searchModel = \common\models\EmplEmployer::find()->asArray()
                ->select('empl_employer.created_at,empl_employer.id,empl_employer.company_name,address.district_id,empl_employer.opening_date,sector.economic_sector_id, empl_employer.ownership_id,address.email_address,address.phone_number,sector.start_date')
                ->LeftJoin('empl_address as address', 'empl_employer.id=address.employer_id')
                ->LeftJoin('empl_economic_sector as sector', 'empl_employer.id=sector.employer_id')
                ->all();

        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $employer = New \common\models\EmplEmployer();
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Company Name');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'District');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Economic Sector');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Opening Date');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Ownership ');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Email');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Phone');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Registration Date');
        $counter = 2;
        foreach ($searchModel as $empl) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $empl['company_name']);
            if (!empty($empl['district_id'])) {
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, SDistrict::findOne($empl['district_id'])->district);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'Not Set');
            }
            if (isset($empl['economic_sector_id'])) {
                $objPHPExcel->getActiveSheet()->setCellValue('c' . $counter, \backend\models\SIsicr4Level4::findOne($empl['economic_sector_id'])->ecosector);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('c' . $counter, 'Not Set');
            }
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $empl['opening_date']);
            if (isset($empl['ownership_id'])) {
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, \common\models\SOwnership::findOne($empl['ownership_id'])->ownership);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'Not Set');
            }
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $empl['email_address']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $empl['phone_number']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $empl['created_at']);

            $counter++;
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "Report-by-Employer.xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
        $objWriter->save('php://output');
        die();
    }

    public function actionIndex() {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('mediator')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $searchModel = new EmplEmployerSearch();
        $dataProvider = $searchModel->searchAdmin(Yii::$app->request->queryParams);

        return $this->render('list/reportList', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEmployersByDistrict() {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('mediator')) {

            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $searchModel = new EmplAddressSearch();
        $dataProvider = $searchModel->searchEmployersReport(Yii::$app->request->queryParams);

        return $this->render('employers-by-district/reportList', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    // public function actionEmployersByEconomicSector()
    // {
    //     if(! Yii::$app->user->can('mediator')){ 
    //         throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
    // }
    //     $searchModel = new EmplEconomicSectorSearch();
    //     $dataProvider = $searchModel->searchJobseekersReport(Yii::$app->request->queryParams, 'jobseekerlist');
    //     return $this->render('by-education-field/reportList', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    public function actionView($district_id = null) {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('mediator')) {

            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $searchModel = new EmplEmployerSearch();
        $dataProvider = $searchModel->searchEmployersbydistrict(Yii::$app->request->queryParams, $district_id);

        return $this->render('list/reportList', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
