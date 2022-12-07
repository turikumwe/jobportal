<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceEventSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-service-event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'event_title')->textInput(['maxlength' => true, 'placeholder' => 'Event Title']) ?>
        </div>

         <div class="col-sm-6">
            <?= $form->field($model, 'event_category_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEventCategory::find()->orderBy('category')->asArray()->all(), 'id', 'category'),
                'options' => ['placeholder' => Yii::t('app', 'Category')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php  echo $form->field($model, 'venue')->textInput(['maxlength' => true, 'placeholder' => 'Venue'])  ?>
        </div>

         <div class="col-sm-6">
            <?= $form->field($model, 'event_location')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SGeosector::find()->orderBy('sector')->asArray()->all(), 'id', 'sector'),
                'options' => ['placeholder' => Yii::t('app', 'District')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>

   

    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
