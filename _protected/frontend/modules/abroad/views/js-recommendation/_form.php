<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsRecommendation */
/* @var $form yii\widgets\ActiveForm */
$user_id = (isset($_GET['idOtherProfile'])) ? $_GET['idOtherProfile'] : 0;
?>

<div class="js-recommendation-form">

    <?php $form = ActiveForm::begin(
        [
            'action' => $url,
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
        ]
    ); ?> 

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \common\models\UserProfile::findUserIdByUser($user_id)])->label(false); ?>

    <?= $form->field($model, 'recommendation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'who_recommended_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>    
</div>
