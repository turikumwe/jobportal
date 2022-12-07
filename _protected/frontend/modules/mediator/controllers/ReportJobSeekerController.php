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
use Yii;
use backend\models\SDistrict;
use frontend\modules\jobseeker\models\search\JsAddressSearch;
use frontend\modules\jobseeker\models\search\JsEducationSearch;
use kartik\grid\GridView;

/**
 * Default controller for the `mediator Report` module
 */
class ReportJobSeekerController extends Controller {

    public function actionExportDatabyEducation() {
        $searchModel = new JsEducationSearch();
        $dataProvider = $searchModel->searchJobseekersReport(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        $data = $dataProvider->getModels();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Education Field')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Total Number')->getStyle('b1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'PhD')->getStyle('c1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('d1', 'Masters')->getStyle('d1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('e1', 'Bachelor')->getStyle('e1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('f1', 'Diploma')->getStyle('f1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Advanced Level')->getStyle('g1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Ordinary Level')->getStyle('h1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '6 Years')->getStyle('i1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('j1', 'Unknown Number')->getStyle('j1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');

        if (count($data) > 0) {
            $counter = 2;
            foreach ($data as $userprofile) {
                $educationfield = \common\models\JsEducation::find()->where(['education_field_id' => $userprofile['education_field_id']])->one();

                if ($educationfield['education_field_id'] == 0) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'Not Set');
                } else {

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, \backend\models\SEducationField::findOne($educationfield['education_field_id'])->field);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $userprofile->totalJobseekersByEducationfield($userprofile->education_field_id));

                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $userprofile->totalWithPhd($userprofile->education_field_id, $userprofile->education_level_id));
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $userprofile->totalWithMasters($userprofile->education_field_id, $userprofile->education_level_id));
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $userprofile->totalWithBachelor($userprofile->education_field_id, $userprofile->education_level_id));
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $userprofile->totalWithDiploma($userprofile->education_field_id, $userprofile->education_level_id));
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $userprofile->totalWithALevel($userprofile->education_field_id, $userprofile->education_level_id));
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $userprofile->totalWith0Level($userprofile->education_field_id, $userprofile->education_level_id));
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, $userprofile->totalWith6Years($userprofile->education_field_id, $userprofile->education_level_id));
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, $userprofile->totalWithUknown($userprofile->education_field_id, $userprofile->education_level_id));

                $counter++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "Report-Jobseeker-by-Education_level.xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
        $objWriter->save('php://output');
        die();
    }

    public function actionExportDatabyDistrict() {
        $searchModel = new JsAddressSearch();
        $dataProvider = $searchModel->searchJobseekerReport(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        $data = $dataProvider->getModels();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'District')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Number')->getStyle('b1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');

        if (count($data) > 0) {
            $counter = 2;
            foreach ($data as $userprofile) {
                $districtid = \common\models\JsAddress::find()->where(['district_id' => $userprofile['district_id']])->one();

                if (($districtid['district_id'] == 0) || $districtid['district_id'] == 600) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'Not Set');
                } else {

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, SDistrict::findone($userprofile->district_id)->district);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $userprofile->totalJobseekersByDistrict($userprofile->district_id));
                $counter++;
            }
            header('Content-Type: application/vnd.ms-excel');
            $filename = "Report-Jobseeker-by-District.xls";
            header('Content-Disposition: attachment;filename=' . $filename . ' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
            $objWriter->save('php://output');
            die();
        }
    }

    public function actionExportData() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchResidence(Yii::$app->request->queryString);
        $dataProvider->pagination = false;
        $data = $dataProvider->getModels();
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->setTitle('Data Export');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'First Name')->getStyle('A1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Last Name')->getStyle('B1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'ID Number')->getStyle('C1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Gender')->getStyle('D1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Jobseeker Age ')->getStyle('E1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Disability')->getStyle('F1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Number of Education')->getStyle('G1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Number of Trainings')->getStyle('H1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Number of Jobs')->getStyle('I1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');

        $objPHPExcel->getActiveSheet()->setCellValue('j1', 'Email')->getStyle('J1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('k1', 'Phone Number')->getStyle('K1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('l1', 'Education level')->getStyle('L1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('m1', 'Education Field')->getStyle('M1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('n1', 'Graduation Year')->getStyle('N1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('o1', 'ESC')->getStyle('O1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'Province')->getStyle('P1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('q1', 'District')->getStyle('Q1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('r1', 'Residence')->getStyle('R1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $objPHPExcel->getActiveSheet()->setCellValue('s1', 'Registration')->getStyle('S1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('cccccc');
        $counter = 2;
        foreach ($data as $userprofile) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $userprofile['firstname']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $userprofile['lastname']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $userprofile['id_number']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, ($userprofile->gender == \common\models\UserProfile::GENDER_MALE) ? 'Male' : 'Female');

            $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $userprofile['age']);

            $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $userprofile['disability_id']);

            $objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $userprofile['countEducation']);

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $userprofile['countTraining']);

            $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, $userprofile['countJobPosition']);

            if (!empty(\common\models\JsAddress::findOne(['user_id' => $userprofile['user_id']])->emailAddress)) {
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, \common\models\JsAddress::findOne(['user_id' => $userprofile['user_id']])->emailAddress);
            }
            if (!empty(\common\models\JsAddress::findOne(['user_id' => $userprofile['user_id']])->phoneNumber)) {
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, \common\models\JsAddress::findOne(['user_id' => $userprofile['user_id']])->phoneNumber);
            }
            $educationfield = \common\models\JsEducation::find()->where(['user_id' => $userprofile['user_id']])->one();
            if ($educationfield['education_level_id'] == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $counter, 'Not Set');
            } else {

                $objPHPExcel->getActiveSheet()->setCellValue('L' . $counter, \backend\models\SEducationLevel::findOne($educationfield['education_level_id'])->level);
            }
            if ($educationfield['education_field_id'] == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $counter, 'Not  Set');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $counter, \backend\models\SEducationField::findOne($educationfield['education_field_id'])->field);
            }
            if ($educationfield['graduation_date'] == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $counter, 'Not Set');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $counter, $educationfield['graduation_date']);
            }
            $district = \common\models\JsAddress::find()->where(['user_id' => $userprofile['user_id']])->one();

            if ($district['district_id'] == 0 || $district['district_id'] == 600) {

                $objPHPExcel->getActiveSheet()->setCellValue('o' . $counter, 'Not Set');
            } else {
                $mediatorid = SDistrict::findOne($district['district_id'])->mediator_id;
                $objPHPExcel->getActiveSheet()->setCellValue('o' . $counter, \common\models\MdMediator::findOne($mediatorid)->madiator_name);
            }

            if ($district['district_id'] == 0 || $district['district_id'] == 600) {

                $objPHPExcel->getActiveSheet()->setCellValue('p' . $counter, 'Not Set');
            } else {
                $provinceid = SDistrict::findOne($district['district_id'])->province_id;
                $objPHPExcel->getActiveSheet()->setCellValue('p' . $counter, \backend\models\SProvince::findOne($provinceid)->province);
            }
            if ($district['district_id'] == 0 || $district['district_id'] == 600) {

                $objPHPExcel->getActiveSheet()->setCellValue('q' . $counter, 'Not Set');
            } else {

                $objPHPExcel->getActiveSheet()->setCellValue('q' . $counter, SDistrict::findOne($district['district_id'])->district);
            }

            $countryid = \common\models\JsAddress::find()->where(['user_id' => $userprofile['user_id']])->one();
            if ($countryid['country_id'] == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue('r' . $counter, 'Not Set');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('r' . $counter, \backend\models\SCountrycodeIso3166::findOne($countryid['country_id'])->cc_description);
            }
            $objPHPExcel->getActiveSheet()->setCellValue('s' . $counter, $userprofile['created_at']);
            $counter++;
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "Jobseekers.xls";
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

        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchResidence(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('jobseekerlist', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'pagination' => $dataProvider->pagination,
        ]);
    }

    public function actionJobseekerByDistrict() {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('mediator')) {

            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $searchModel = new JsAddressSearch();
        $dataProvider = $searchModel->searchJobseekerReport(Yii::$app->request->queryParams);

        return $this->render('report-jobseeker/reportList', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJobseekerByEducationLevel() {
        $this->layout = 'dashboard';
        if (!Yii::$app->user->can('mediator')) {

            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $searchModel = new JsEducationSearch();
        $dataProvider = $searchModel->searchJobseekersReport(Yii::$app->request->queryParams);

        return $this->render('by-education-level/reportList', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($district_id = null) {
        if (!Yii::$app->user->can('mediator')) {

            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->searchJobseekersbydistrict(Yii::$app->request->queryParams, $district_id);

        return $this->render('jobseekerlist', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
