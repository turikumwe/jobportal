<?php
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use common\models\UserProfile;

/* @var $this yii\web\View */
/* @var $model common\models\JsMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-message-form">

    <?php $form = ActiveForm::begin(
        [
            'action' => $url,
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
        ]
    ); ?> 

    <?= $form->field($model, 'js_to_email')->textInput(['id' => 'jsmessage-js_to_email_'.$id,'maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['id' => 'jsmessage-subject_'.$id,'maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['id' => 'jsmessage-body_'.$id,'rows' => 6]) ?>

    <?= $form->field($model, 'type')->hiddenInput(['id' => 'jsmessage-type_'.$id,'value' => 1])->label(false) ?>
  
	
  	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>
    
</div>
