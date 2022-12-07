<?php

namespace backend\controllers;

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
            foreach($sectors as $sector){
                $option = "<option ></option>";
                $option.= "<option value='".$sector->id."'>".$sector->sector."</option>";
                echo $option;
            }
        }else{
            echo "<option>-</option>";
        }
    }
}
