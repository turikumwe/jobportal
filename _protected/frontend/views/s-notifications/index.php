<?php
use kartik\typeahead\TypeaheadBasic;
use common\models\JsRecommendation;
use common\models\SNotifications;
use frontend\assets\FrontendAsset;
use trntv\filekit\widget\Upload;
use common\models\JsExperience;
use kartik\typeahead\Typeahead;
use kartik\widgets\SwitchInput;
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

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */
$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Profile')
?>
<div class="kora-container vd_content-section clearfix">
    <div class="row">
        <div class="col-sm-3">
            <?= Yii::$app->jobSeeker->menu();?>
        </div>

        <div class="col-sm-6">
            <div class="tabs widget">
                <ul class="nav nav-tabs widget">
                    <li> 
                        <a href="<?= Yii::$app->link->frontendUrl('/jobseeker/user-profile/')?><?= (Yii::$app->user->can('employer') || Yii::$app->user->can('mediator'))?'admin':''?>">
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th><h1>Notification Settings</h1></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($opportunities as $opportunity){ ?>
                            <?php 
                            $check = SNotifications::check($opportunity->id);
                            if(!is_object($check)){
                                $notification = false;
                            }else{
                                if($check->deleted_by == 0){
                                    $notification = true;
                                }else{
                                    $notification = false;
                                }
                            }
                            ?>
                        <tr>
                        <td>    
                            <a href="#" onClick="notification(<?= $opportunity->id?>)"class="mgbt-xs-15 font-semibold">
                                <input 
                                    type="checkbox" 
                                    id="input_notification" 
                                    value="<?= (!$notification) ? 0 : 1?>" 
                                    <?= ($notification) ? 'checked' : ''?>
                                > 
                                <?= $opportunity->name?>
                            </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <?= Yii::$app->jobSeeker->search();?>
    </div>
</div>
<script>
    function notification(opportunity_id){

        $.ajax({
                type: "POST",
                url: "/s-notifications/settings?opportunity_id="+opportunity_id,
                dataType: "json",
                success: function(data){ 

                }
        });
    }
</script>
