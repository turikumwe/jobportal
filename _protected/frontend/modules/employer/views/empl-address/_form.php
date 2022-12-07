<?php

use backend\models\SGeosector;
use backend\models\SDistrict;
use backend\models\SProvince;
use \yii\helpers\ArrayHelper;
use \kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\MdAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empl-address-form">

    <?php
    $form = ActiveForm::begin(
                    [
                        'action' => $url,
                        'enableClientValidation' => false,
                        'enableAjaxValidation' => true,
                    ]
    );
    ?>

    <?= $form->errorSummary($model); ?>


<?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
            <?= $form->field($model, 'employer_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false); ?>

    <div class='row'>
        <div class="col-md-4">
            <?php
            $model->province_id = $model->province;
            echo $form->field($model, 'province_id')->dropDownList(
                    ArrayHelper::map(SProvince::form(), 'id', 'province'),
                    [
                        'id' => 'mdemployee-province_id_' . $id,
                        'prompt' => Yii::t('app', 'Select Province'),
                        'onchange' => '
                                    $.post( "' . Url::to(['/s-district/lists', 'id' => '']) . '"+$(this).val(),function(data){
                                    $("#mdemployee-district_id_' . $id . '").html(data);
                                    });'
                    ]
            );
            ?>
        </div>
        <div class="col-md-4">
            <?php
            $model->district_id = $model->district;
            echo $form->field($model, 'district_id')->dropDownList(
                    ArrayHelper::map(SDistrict::form($model->district), 'id', 'district'),
                    [
                        'id' => 'mdemployee-district_id_' . $id,
                        'prompt' => 'Select District',
                        'onchange' => '
                        $.post( "' . Url::to(['/s-geo-sector/lists', 'id' => '']) . '"+$(this).val(),function(data){
                        $("#mdemployee-geo_sector_id_' . $id . '"  ).html(data);
                    });'
                    ]
            );
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'geo_sector_id')->dropDownList(
                    ArrayHelper::map(SGeosector::form($model->geo_sector_id), 'id', 'sector'),
                    [
                        'id' => 'mdemployee-geo_sector_id_' . $id,
                        'prompt' => Yii::t('app', 'Sector')
                    ]
            );
            ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-md-6">
<?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Phone number']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'pobox')->textInput(['maxlength' => true, 'placeholder' => 'P.o.Box']) ?>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-12">
            <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'placeholder' => 'www.example.com']) ?>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-12">
            <?= $form->field($model, 'email_address')->textInput(['maxlength' => true, 'placeholder' => 'Email address']) ?>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-12">
            <?= $form->field($model, 'physical_address')->textArea(['maxlength' => true, 'placeholder' => 'Physical address']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php if (!Yii::$app->request->isAjax) { ?>
                <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
    <?php } ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>