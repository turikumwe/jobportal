<?php

use \yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \kartik\widgets\Select2;
use backend\models\SDistrict;
/* @var $this yii\web\View */
/* @var $model common\models\JsAddress */
/* @var $form yii\widgets\ActiveForm */

$model->province_id = SDistrict::findOne($model->district_id)['province_id'];

?>

<div class="js-address-form">

    <?php $form = ActiveForm::begin(
        [
            'action' => $url,
            //'enableClientValidation' => false,
            //'enableAjaxValidation' => true,
        ]
    ); ?>


    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['id' => 'jsaddress-id_' . $id, 'style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['id' => 'jsaddress-user_id_' . $id, 'value' => \Yii::$app->user->id])->label(false) ?>
    
    <div class="inline__flds">
        <div class="input__fld">
            <?= $form->field($model, 'province_id')->dropDownList(
                ArrayHelper::map(\backend\models\SProvince::find()->orderBy('province')->asArray()->all(), 'id', 'province'),
                [
                    'id' => 'province_' . $id,
                    'prompt' => Yii::t('app', 'Choose Province'),
                    'onchange' => '
                            $.post( "' . Url::to(['/s-district/lists', 'id' => '']) . '"+$(this).val(),function(data){
                                $("#district_' . $id . '" ).html(data);
                            });'
                ]
            );
            ?>
        </div>
        <div class="input__fld">
            <?= $form->field($model, 'district_id')->dropDownList(
                ArrayHelper::map(SDistrict::find()->orderBy('district')->asArray()->all(), 'id', 'district'),
                [
                    'id' => 'district_' . $id,
                    'prompt' => 'Select a district',
                    'onchange' => '
                        $.post( "' . Url::to(['/s-geo-sector/lists', 'id' => '']) . '"+$(this).val(),function(data){
                        $("#sector_' . $id . '" ).html(data);
                    });'
                ]
            );
            ?>
        </div>
        <div class="input__fld">
            <?= $form->field($model, 'sector_id')->dropDownList(
                ArrayHelper::map(\backend\models\SGeosector::find()->orderBy('sector')->asArray()->all(), 'id', 'sector'),
                ['id' => 'sector_' . $id, 'prompt' => Yii::t('app', 'Choose a Sector')]
            );
            ?>
        </div>
    </div>
    <div class="inline__flds">
        <div class="input__fld">
            <?= $form->field($model, 'emailAddress')->hiddenInput(['id' => 'jsaddress-emailaddress_' . $id, 'maxlength' => true, 'placeholder' => 'EmailAddress'])->label(false); ?>
        </div>
        <div class="input__fld">

            <?= $form->field($model, 'phoneNumber')->hiddenInput(
                ['id' => 'jsaddress-phoneNumber_' . $id, 'maxlength' => true, 'placeholder' => 'PhoneNumber']
            )->label(false);
            ?>
        </div>
    </div>
    <div class="inline__flds">
        <div class="input__fld">
            <?= $form->field($model, 'pobox')->textInput(
                ['id' => 'jsaddress-pobox_' . $id, 'maxlength' => true, 'placeholder' => 'Pobox']
            )
            ?>
        </div>
        <div class="input__fld">
            <?= $form->field($model, 'physicalAddress')->textInput(
                ['id' => 'jsaddress-physicalAddress_' . $id, 'maxlength' => true, 'placeholder' => 'PhysicalAddress']
            )
            ?>
        </div>
    </div>
    <div class="inline__flds">
        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php } ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>