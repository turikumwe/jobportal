<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmplStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empl-status-form">

    <?php $form = ActiveForm::begin(['action' => $url]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'employer_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?=
    $form->field($model, 'employer_status_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\backend\models\SEmployerStatus::find()->orderBy('id')->asArray()->all(), 'id', 'status'),
            ['prompt' => Yii::t('app', 'Select Employer Status')]);
    ?>

    <div class='row'>
        <div class="col-md-12">
            <?= $form->field($model, 'status_effective_date')->dateInput(['maxlength' => true, 'placeholder' => 'Start date']) ?>
        </div>
    </div>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
<?php } ?>

<?php ActiveForm::end(); ?>

</div>
