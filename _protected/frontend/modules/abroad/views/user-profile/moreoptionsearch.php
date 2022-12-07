<?php
use kartik\typeahead\TypeaheadBasic;

use frontend\assets\FrontendAsset;
use trntv\filekit\widget\Upload;
use common\models\JsExperience;
use kartik\typeahead\Typeahead;
use common\models\JsEducation;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\JsEndorse;
use common\models\JsAddress;
use common\models\JsSkill;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Service Job'); 
$this->params['breadcrumbs'][] = $this->title; 
$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(1000); 
    return false; 
});"; 

$this->registerJs($search); 

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */
$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Profile');

?>
<style>
    .modal-header {
        background-color: #e3e3e3;
    }

     .modal-footer {
        position:absolute;
        bottom:0;
        left:0;
        right:0;
        background-color: #e3e3e3;
        height: 50px;
    }

    .modal-dialog {
        position:absolute;
        top:50% !important;
        transform: translate(0, -50%) !important;
        -ms-transform: translate(0, -50%) !important;
        -webkit-transform: translate(0, -50%) !important;
        margin:auto 20%;
        width:60%;

    }
</style>
<div class="vd_content-section clearfix">
    <p> 
        <?= Html::a(Yii::t('app', 'Advanced Search'), '#', ['class' => 'pull-right btn btn-info search-button']) ?> 
    </p> 
    
    <div  id='search'>
        <div class="row">

            <div class="col-sm-3">
                <?php 
                    if(Yii::$app->user->can('mediator')) { 
                        echo Yii::$app->jobSeeker->menu();
                    } elseif(Yii::$app->user->can('employer')) { 
                        echo Yii::$app->jobSeeker->menu();
                    } else { 
                        echo Yii::$app->jobSeeker->profile($profile);   
                    } 

                    // include("search/salary_range.php");
                    // include("search/date_posted.php");
                    // include("search/qualification.php");
                    // include("search/job_type.php");
                ?>
                <?php if(!Yii::$app->user->can('user')) { ?>
                <div>
                    <center> 
                        <h2>
                            <a href=<?= (Yii::$app->user->can('employer')) ? '/employer/empl-employer/post-job' : '/mediator/md-mediator/post-job' ?>
                                <span class="label label-danger" style="color:white">Post a Job</span>
                            </a>
                        </h2>
                    </center>
                </div>
            <?php } ?>
            </div>
        
            <div class="col-sm-6">
                <div class="search-form" style="display:none"> 
                    <?=  $this->render('_search', ['model' => $searchModel]); ?> 
                </div> 

                <div class="tabs widget">
                    <ul class="nav nav-tabs widget">
                        <li><a href="/service/service-job"><i class="glyphicon glyphicon-home"></i></a></li>
                        <li class="active"> 
                            <a data-toggle="tab" href="#profile-tab"> Options 
                                <span class="menu-active">
                                    <i class="glyphicon glyphicon-triangle-top"></i>
                                </span> 
                            </a>
                        </li>
                       
                    </ul>
                    
                    <div class="tab-content">

                        <div id="profile-tab" class="tab-pane active">
                            <div class="pd-20" id="job"> 
                                <?php //include('jobs.php');  ?>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>

            
            <div class="col-sm-3">
                <?php include("simple_search.php")?>
                <?= Yii::$app->jobSeeker->menu(); ?>

            </div>

        </div>
    </div>
</div>
