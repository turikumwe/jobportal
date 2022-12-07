<?php
/**
 * Created by PhpStorm.
 * User: Pacifique Karinda.
 * Date: 26/10/19
 * Time: 7:30 AM
 */

namespace frontend\components\myfield;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class Myfield
{
    public function myUpload($mymodel,$myattribute)
    {
        $mymodel->$myattribute = UploadedFile::getInstance($mymodel, $myattribute);

        if ($mymodel->$myattribute && $mymodel->validate()) {
            $filename = time().'_'. $mymodel->$myattribute->baseName.'.'.$mymodel->$myattribute->extension;

            if(strtolower($mymodel->$myattribute->extension) == 'pdf'){
                $mymodel->$myattribute->saveAs(Yii::getAlias('@storage').'/source/1/'.$filename);
                return '1/' . $filename; 
            }
            elseif (strtolower($mymodel->$myattribute->extension) == 'png') {
                $mymodel->$myattribute->saveAs(Yii::getAlias('@storage') . '/source/1/' . $filename);
                return '1/' . $filename;
            }
            else 
                return Null;
        }
    }
}
