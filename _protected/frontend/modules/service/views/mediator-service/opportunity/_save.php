<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsJobApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-event-application-form">

    <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl('/service/service-event/save-event')]);
    ?>

    <?= $form->errorSummary($model); ?>
    <?= $form->field($model, 'event_id')->hiddenInput(['value' => $get->id])->label(false); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

        <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group" style="text-align: center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Click here if you want to save this opportunity') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

<?php ActiveForm::end(); ?>

</div>
