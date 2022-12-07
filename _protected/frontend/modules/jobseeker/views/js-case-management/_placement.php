<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\SServices;
/* @var $this yii\web\View */
/* @var $model common\models\JsCaseManagement */
/* @var $form yii\widgets\ActiveForm */
$service = SServices::find()->where(['name'=> 'Placement'])->one(); 
?>
<style>
.well {
    background-color: white
}
    .modal-dialog {
        position:absolute;
        top:50% !important;
        transform: translate(0, -50%) !important;
        -ms-transform: translate(0, -50%) !important;
        -webkit-transform: translate(0, -50%) !important;
        margin:auto 20%;
        width:60%;
        height:80%;
    }
    .modal-content {
        min-height:100%;
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        right:0; 
    }
    .modal-body {
        position:absolute;
        top:45px; /** height of header **/
        bottom:45px;  /** height of footer **/
        left:0;
        right:0;
        overflow-y:auto;
    }
    .modal-footer {
        position:absolute;
        bottom:0;
        left:0;
        right:0;
    }

</style>
<div class="js-case-management-form">

    <?php $form = ActiveForm::begin([
            'action' => $url,
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
        ]); ?>
    
        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    
        <table class="table table-striped table-bordered" style="width:98%;margin-left:5px;">
            <tr><td colspan="3"><b>Identification</b></td></tr>
            <tr>
                <td>
                    <b>Name:</b><?= $get->userProfile->fullName?>
                </td>
                <td>
                    <b>District:</b><?= isset($get->jsAddress->district->district) ? $get->jsAddress->district->district : ''?>
                </td>
                <td>
                    <b>Reference:</b><?= $get->userProfile->reference_number?>
                </td>
            </tr>
            <tr>
                <th>Professional</th>
                <th colspan="2"><center>Education</center></th>
            </tr>
            <tr>
                <td>
                    <b>Experience:</b><?php //$get->userProfile->fullName?>
                </td>
                <td>
                    <b>Level:</b><?= isset($get->jsEducation->educationLevel->level) ? $get->jsEducation->educationLevel->level : "-" ?>
                </td>
                <td>
                    <b>Field:</b><?= isset($get->jsEducation->educationField->field) ? $get->jsEducation->educationField->field : "-" ?>
                </td>
            </tr>
        </table>
        <table class="table table-striped table-bordered" style="width:98%;margin-left:5px;">
            <tr><td colspan="2"><b>Application</b></td></tr>
            <?php if($applicationjob)  { ?>
            <tr>               
                <td><b>Job Title:</b> <?= $applicationjob->job->jobtitle ?></td>
                <td><b>Application Date:</b> <?= $applicationjob->application_date?></td>                
            </tr>
            <tr>               
                <td><b>Employer:</b> <?= $applicationjob->job->employer ?></td>
                <td><b>Opportunity:</b> <?= $applicationjob->job->opportunity->name?></td>                
            </tr>
            <?php } ?>

              <?php if($applicationevent)  { ?>
            <tr>               
                <td><b>Event Title:</b> <?= $applicationevent->even->event_title ?></td>
                <td><b>Application Date:</b> <?= $applicationevent->application_date?></td>                
            </tr>
            <tr>               
                <td><b>Organizer Email:</b> <?= $applicationevent->even->contact_email ?></td>
                <td><b>Opportunity:</b> <?= $applicationevent->even->opportunity->name?></td>                
            </tr>
            <?php } ?>
        </table>
       
        <h4><center><b><u>Service Name:<?= $service->name?></u></b></center>
   
        <div class="col-md-12">
            <?= $form->field($model, 'geven_service_description')->textarea(['rows' => 6]) ?>
        </div>
   
        <div class="col-md-6">
            <?= $form->field($model, 'given_service')->hiddenInput(['value' => $service->id])->label(false) ?>
            <?= $form->field($model, 'mediotor_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
            <?= $form->field($model, 'jobseeker_id')->hiddenInput(['value' => $user_id])->label(false) ?>
            <?= $form->field($model, 'application_id')->hiddenInput(['value' => $application_id])->label(false) ?>
        </div>
  
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
