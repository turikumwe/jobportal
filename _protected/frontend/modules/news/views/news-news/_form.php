<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\NewsNews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'headline')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, Html::encode('link'))->textInput(['maxlength' => true, 'onChange' => 'removeHttps("newsnews-link")']) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publication_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('frontend', 'Publication date'),
                'autoclose' => true
            ]
        ],
    ]); ?>



    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<script>
    function removeHttps(id) {
        let n = $("#" + id).val().toLowerCase().match('http://');
        if (n != null) {
            let httplink = $("#" + id).val().toLowerCase().replace('http://', '');
            $("#" + id).val(httplink);
        } else {
            let httplink = $("#" + id).val().toLowerCase().replace('https://', '');
            $("#" + id).val(httplink);
        }
    }
</script>