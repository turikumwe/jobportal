<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsEventApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-event-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    
    <?= $form->field($model, 'status_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SStatus::find()->orderBy('status')->asArray()->all(), 'pk_status', 'status'),
        'options' => ['placeholder' => Yii::t('app', 'Status')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'placement')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map( [
                        ['id' => 0 , 'name' => 'No'],
                        ['id' => 1 , 'name' => 'Yes']
                    ], 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app', 'Completed')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>



