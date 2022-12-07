<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\JsSummary */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="js-summary-form container"><br>

    <?php $form = ActiveForm::begin(
        [
            'action' => $url,
            // 'enableClientValidation' => false,
            // 'enableAjaxValidation' => true,
        ]
    ); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <div class="row">
        <div class="col col-sm-7">
            <?php
            // echo $form->field($model, 'cvFile')->widget(
            //     Upload::class,
            //     [
            //             'url' => ['/jobseeker/js-summary/cv-upload'],
            //             'sortable' => true,
            //             'maxFileSize' => 10000000, // 10 MiB
            //             'maxNumberOfFiles' => 1,
            //         ]
            // );
            echo $form->field($model, 'cvFile')->fileInput();
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-7">
            <?= $form->field($model, 'professional_profile')->textarea(['rows' => 2,'cols'=>3]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-7">
            <?= $form->field($model, 'cover_letter')->textarea(['rows' => 3]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-7">
            <?= $form->field($model, 'specialty')->textarea(['rows' => 3]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-7">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>