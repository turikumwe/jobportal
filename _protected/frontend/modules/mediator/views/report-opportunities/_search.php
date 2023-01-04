<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmplEmployerSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="empl-employer-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['job'],
                'method' => 'get',
    ]);
    ?>
    <?=
    $form->field($model, 'start')->dateInput(['maxlength' => true, 'placeholder' => 'To',
        'autoclose' => true, 'saveFormat' => 'php:Y-m-d'])
    ?>

    <?=
    $form->field($model, 'end')->dateInput(['maxlength' => true, 'placeholder' => 'To',
        'autoclose' => true, 'saveFormat' => 'php:Y-m-d'])
    ?>






    <br>
    <div class="form-group">
<?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
