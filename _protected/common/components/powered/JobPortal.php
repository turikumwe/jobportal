<?php
namespace common\components\powered;
use Yii;

class JobPortal extends Yii
{
    public static function powered()
    {
         return '<a href="http://jobportal.oo/" rel="external">' .Yii::t("common","Powered by Job Portal Rwanda").'</a>';
    }
}