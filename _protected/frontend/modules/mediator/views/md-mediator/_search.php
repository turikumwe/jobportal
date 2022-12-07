<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\MdMediatorSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="md-mediator-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'registration_authority_id') ?>

    <?php echo $form->field($model, 'registration_number') ?>

    <?php echo $form->field($model, 'madiator_name') ?>

    <?php echo $form->field($model, 'mediator_type_id') ?>

    <?php // echo $form->field($model, 'opening_date') ?>

    <?php // echo $form->field($model, 'ownership_id') ?>

    <?php // echo $form->field($model, 'show_address') ?>

    <?php // echo $form->field($model, 'show_manager') ?>

    <?php // echo $form->field($model, 'show_employee') ?>

    <?php // echo $form->field($model, 'terminate') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'deleted_by') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
