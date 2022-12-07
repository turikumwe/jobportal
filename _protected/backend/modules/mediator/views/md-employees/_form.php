<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MdEmployees */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="md-employees-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?=
    $form->field($model, 'mediator_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\MdMediator::find()->orderBy('id')->asArray()->all(), 'id', 'madiator_name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Mediator')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?php
    // echo $form->field($model, 'person_id')->widget(\kartik\widgets\Select2::classname(), [
    //     'data' => \yii\helpers\ArrayHelper::map(\common\models\CommonPerson::employerManagers()->asArray()->all(), 'id', 'fullName'),
    //     'options' => ['placeholder' => Yii::t('app', 'Choose Manager')],
    //     'pluginOptions' => [
    //         'allowClear' => true
    //     ],
    // ]); 
    ?>
            <?php include('_personForm.php'); ?>

    <div class="row">
        <div class="col col-md-4"> 
            <?=
            $form->field($model, 'position_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\SMediatorPosition::find()->orderBy('position')->asArray()->all(), 'id', 'position'),
                'options' => ['placeholder' => Yii::t('app', 'Select position')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col col-md-4">  
            <?=
            $form->field($model, 'start_date')->widget(\kartik\datecontrol\DateControl::classname(), [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => false,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => Yii::t('app', 'Choose Start Date'),
                        'autoclose' => true
                    ]
                ],
            ]);
            ?>
        </div>
        <div class="col col-md-4">
            <?=
            $form->field($model, 'end_date')->widget(\kartik\datecontrol\DateControl::classname(), [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => false,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => Yii::t('app', 'Choose End Date'),
                        'autoclose' => true
                    ]
                ],
            ]);
            ?>
        </div>
    </div>

<?php 
if ($model->isNewRecord) {
  include('_userForm.php');   
}

?>

<?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
<?php } ?>

<?php ActiveForm::end(); ?>

</div>
