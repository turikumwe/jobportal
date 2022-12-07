<?php
/**
 * Created by PhpStorm.
 * User: Ntabana coco.
 * Date: 02/09/18
 * Time: 9:00 PM
 */

namespace frontend\components\url;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

class Link
{
    public function frontendUrl($link)
    {
        if (isset($_SERVER['FRONTEND_BASE_URL'])) {
            $frontend_base_url = ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'];
            return $frontend_base_url.$link;
        }
        
        return 'jobportal'.$link;
    }
}
