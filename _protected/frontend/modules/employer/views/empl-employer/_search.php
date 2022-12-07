<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmplEmployerSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="empl-employer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    
    <?php echo $form->field($model, 'company_name') ?>

    <?php echo $form->field($model, 'company_name_abbraviatio') ?>

    <?php echo $form->field($model, 'avatar_path') ?>

    <?php echo $form->field($model, 'avatar_base_url') ?>

    <?php // echo $form->field($model, 'parent') ?>

    <?php // echo $form->field($model, 'child') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
