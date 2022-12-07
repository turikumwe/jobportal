<?php

namespace frontend\controllers;

use Yii;
use backend\models\SDistrict;
use backend\models\SDistrictSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SDistrictController implements the CRUD actions for SDistrict model.
 */
class SDistrictController extends Controller
{

    public function actionLists($id){
          
        $countDistrict = Sdistrict::find()
                    ->where('province_id=:u',['u'=>$id])
                    ->count();

        $districts = Sdistrict::find()
                   ->where('province_id=:u',['u'=>$id])
                    ->all(); 


        if($countDistrict > 0){
            echo "<option >Select District</option>";
            foreach($districts as $district){
                echo "<option value=$district->id>".$district->district."</option>";
            }
        }else{
            echo "<option>-</option>";
        }

        die;
    }
}
