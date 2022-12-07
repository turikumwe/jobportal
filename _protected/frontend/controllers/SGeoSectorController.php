<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use backend\models\SGeosector;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * SDistrictController implements the CRUD actions for SDistrict model.
 */
class SGeoSectorController extends Controller
{

    public function actionLists($id){
          
        $countDistrict = SGeosector::find()
                    ->where('district_id=:u',['u'=>$id])
                    ->count();

        $sectors = SGeosector::find()
                   ->where('district_id=:u',['u'=>$id])
                    ->all(); 


        if($countDistrict > 0){
            echo "<option >Select District</option>";
            foreach($sectors as $sector){
                echo "<option value='".$sector->id."'>".$sector->sector."</option>";
            }
        }else{
            echo "<option>-</option>";
        }

        die;
    }
}
