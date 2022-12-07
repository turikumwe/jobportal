<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmplEconomicSector */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empl-economic-sector-form">

    <?php $form = ActiveForm::begin(['action' => $url]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'employer_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?=
    $form->field($model, 'economic_sector_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\backend\models\SIsicr4Level4::find()->orderBy('id')->asArray()->all(), 'id', 'ecosector'),
            [
                'id' => 'employer-economic_sector_id' . $id,
                'prompt' => Yii::t('app', 'Select Economic Sector')
    ]);
    ?>

    <?=
    $form->field($model, 'main_economic_sector_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\backend\models\SMainecosector::find()->orderBy('id')->asArray()->all(), 'id', 'sector'),
            [
                'id' => 'employer-main_economic_sector_id' . $id,
                'prompt' => Yii::t('app', 'Select Main Economic Sector')
    ]);
    ?>
    <div class='row'>
        <div class="col-md-12">
            <?= $form->field($model, 'start_date')->dateInput(['maxlength' => true, 'placeholder' => 'Start date']) ?>
        </div>
    </div>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
