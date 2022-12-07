<?php
use kartik\typeahead\TypeaheadBasic;
use common\models\JsRecommendation;
use frontend\assets\FrontendAsset;
use trntv\filekit\widget\Upload;
use common\models\JsExperience;
use kartik\typeahead\Typeahead;
use common\models\UserProfile;
use common\models\JsEducation;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\JsEndorse;
use common\models\JsAddress;
use common\models\JsSkill;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */
$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Profile')
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
    <div  id='search'>
    <div class="row">

        <div class="col-sm-3">  
            <?= Yii::$app->jobSeeker->menu();?>
        </div>
   
        <div class="col-sm-6">
            <div class="tabs widget">
                <ul class="nav nav-tabs widget">
                    <li> 
                        <a href="/jobseeker/user-profile/<?= (Yii::$app->user->can('employer') || Yii::$app->user->can('mediator'))?'admin':''?>">
                            <i class="glyphicon glyphicon-home"></i>
                        </a>
                    </li>
                    <li class="active"> 
                        <a data-toggle="tab" href="#profile-tab"> Profile 
                            <span class="menu-active">
                                <i class="glyphicon glyphicon-triangle-top"></i>
                            </span> 
                        </a>
                    </li>  
                </ul>
                
                <div class="tab-content">
                    
                    <div id="profile-tab" class="tab-pane active">
                        <div class="pd-20">  
                            <?php include('_view.php')?>
                        </div> 
                    </div>
                <!-- home-tab -->
                </div>

            </div>
        </div> 

        <div class="col-sm-3">
            <?= Yii::$app->jobSeeker->search();?>
           <div class="alert alert-success" role="alert">
                <h3>New Driving license category is added &nbsp;<i class="glyphicon glyphicon-ok"></i></h3>
           </div>
        </div> 
    </div>
    </div>

</div>
<script>
    function remove(id,url,div) {
        if(confirm("Are you sure?.")){
            $.ajax({
                type: "POST",
                url: "/jobseeker/"+url+"/delete?id="+id,
                dataType: "json",
                success: function(data){ 
                    $("#"+div).load(" #"+div);
                }
            });
        }
   }

   function search(idOtherProfile) {
        window.location.href= "/jobseeker/user-profile/index?idOtherProfile="+idOtherProfile;
        
        //window.history.pushState("Profile", "Title", "/jobseeker/user-profile/index?idOtherProfile="+idOtherProfile);
        //$("#search").load(" #search");
   }
</script>