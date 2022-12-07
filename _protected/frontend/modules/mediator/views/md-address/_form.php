<?php
use backend\models\SGeosector;
use backend\models\SDistrict;
use backend\models\SProvince;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\MdAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="md-address-form">

    <?php $form = ActiveForm::begin(
        [
            'action' => isset($url) ? $url : $_SERVER['REQUEST_URI'],
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
        ]
    ); ?> 

    <?= $form->errorSummary($model); ?>
   
    <div class='row'>
    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(
                                                    [
                                                        'style' => 'display:none',
                                                        'id' => 'md-address_id_'.$id
                                                    ]) ?>
    <?= $form->field($model, 'mediator_id')->hiddenInput( 
                                                            [ 
                                                                'value' => Yii::$app->user->id,
                                                                'id' => 'mdaddress-mediator_id_'.$id,
                                                            ])->label(false); ?>
    <div class="col-md-4">
        <?php 
        $model->province_id = $model->province;
        echo $form->field($model, 'province_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(SProvince::form(), 'id', 'province'),
        'theme' => Select2::THEME_KRAJEE, 
                    'options'=>[
                        'id' => 'mdaddress-province_id_'.$id,
                        'placeholder'=>Yii::t('app', 'Choose Province'),
                        'onchange'=>'
                        $.post( "'.Url::to(['/s-district/lists', 'id' => '']).'"+$(this).val(),function(data){
                         $("#mdaddress-district_id_'.$id.'" ).html(data);
                        });'
                    ],
                    'language' => 'en',
                    'pluginOptions'=>['alloweClear'=>true],
        ]); ?>
            </div>
            <div class="col-md-4">
                <?php 
                $model->district_id = $model->district;
                echo $form->field($model, 'district_id')->widget(Select2::class,[
                'data' => ArrayHelper::map(SDistrict::form($model->district), 'id', 'district'),
                'options'=>[
                    'id' => 'mdaddress-district_id_'.$id,
                    'placeholder'=>'Select a district',
                    'onchange'=>'
                        $.post( "'.Url::to(['/s-geo-sector/lists', 'id' => '']).'"+$(this).val(),function(data){
                        $("#mdaddress-geo_sector_id_'.$id.'" ).html(data);
                    });'
                ],
                'language' => 'en',
                'pluginOptions'=>['alloweClear'=>true],
                ]);
                ?>  
            </div>
           
            <div class="col-md-4">
                <?= $form->field($model, 'geo_sector_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(SGeosector::form($model->geo_sector_id), 'id', 'sector'),
                'options' => [
                    'id' => 'mdaddress-geo_sector_id_'.$id,
                    'placeholder' => Yii::t('app', 'Choose Sector')
                ],
                'pluginOptions' => [
                'allowClear' => true
                ],
                ]); ?>
            </div>
        </div>

        <div class='row'> 
             <div class="col-md-6">
                <?= $form->field($model, 'phone_number')->textInput(
                    [
                        'maxlength' => true, 
                        'placeholder' => 'Phone Number',
                        'id' => 'mdaddress_phone_number_'.$id
                    ]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'pobox')->textInput(
                    [
                        'maxlength' => true, 
                        'placeholder' => 'PoBox',
                        'id' => 'md-address_pobox_'.$id

                ]) ?>
            </div>

        </div>
        <div class='row'> 
            <div class="col-md-6">
                <?= $form->field($model, 'email_address')->textInput(
                    [
                        'maxlength' => true, 
                        'placeholder' => 'Email Address',
                        'id' => 'mdaddress_email_address_'.$id
                ]) ?>
            </div>

            <div class="col-md-6">
                 <?= $form->field($model, 'physical_address')->textArea(
                    [
                        'maxlength' => true, 
                        'placeholder' => 'Physical Address',
                        'id' => 'mdaddress_physical_address_'.$id
                    ]) ?>
            </div>

        </div>

    <div class="row">
        <div class="col-md-12">
	<?php if (!Yii::$app->request->isAjax){ ?>
    	  	<div class="form-group">
    	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    	    </div>
        </div>
    <?php } ?>
    </div>
	

    <?php ActiveForm::end(); ?>
    
</div>
