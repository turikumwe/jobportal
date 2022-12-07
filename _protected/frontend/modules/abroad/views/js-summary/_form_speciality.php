<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\JsSummary */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="js-summary-form">

<?php $form = ActiveForm::begin(
        [
            'action' => $url,
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
        ]
    ); ?>  

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?= $form->field($model, 'specialty')->textarea(['rows' => 6]) ?>

     <?php 
        // echo $form->field($model, 'cvFile')->widget(
        // Upload::class,
        // [
        //     'url' => ['/jobseeker/js-summary/cv-upload'],
        //     'sortable' => true,
        //     'maxFileSize' => 10000000, // 10 MiB
        //     'maxNumberOfFiles' => 1,
        // ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
