<!doctype html>
<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'User Profiles');
$this->params['breadcrumbs'][] = $this->title;

$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(1000); 
    return false; 
});";
$this->registerJs($search);

CrudAsset::register($this);

?>
<html lang="en" class="pxp-root">
    <head>
        

        <title>Jobportal </title>
    </head>
    <body style="background-color: var(--pxpMainColorLight);">
        <div class="pxp-preloader"><span>Loading...</span></div>

         
        <div class="pxp-container">
            <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/seeker_top_header.php") ?>
    

            <div class="pxp-dashboard-content-details">
                  
                <div class="mt-4">
                    
                    <div class="table-responsive table-hover">
                       <?= $content;?> 
                             
                   
                    </div>
                </div>
            </div>

             
        </div>

        
    </body>
</html>