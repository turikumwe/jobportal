<?php

use trntv\filekit\widget\Upload;
use Common\models\UserProfile;
use \yii\helpers\ArrayHelper;
use \kartik\widgets\Select2;
use yii\helpers\Url;
use backend\models\SGeosector;
use backend\models\SProvince;
use backend\models\SDistrict;

if (isset($model->province_id)) {

    $model->district_id = SDistrict::find()->where(['province_id' => $model->province_id])['district_id'];
    $model->geo_sector_id = SGeosector::find()->where(['district_id' => $model->district_id])['sector_id'];
}
?>



<div class='input-text'> 
    <div class="input-div">
        <?=
        $form->field($address, 'province_id')->dropDownList(
                ArrayHelper::map(SProvince::find()->orderBy('province')->where(['!=', 'id', 6])->asArray()->all(), 'id', 'province'),
                [
                    'id' => 'province_id',
                    'prompt' => Yii::t('frontend', 'Select Province'),
                    'onchange' => '
                            $.post( "' . Url::to(['/s-district/lists', 'id' => '']) . '"+$(this).val(),function(data){
                                $( "#district_id" ).html( data );
                            });
                        '
                ]
        )->label(Yii::t('frontend', 'Province') . ' <sup><span style="color:red">*</span></sup>')
        ?> 

    </div>
    <div class="input-div">
        <?=
        $form->field($address, 'district_id')->dropDownList(
                ArrayHelper::map(SDistrict::find()->orderBy('district')->where(['!=', 'province_id', 6])->asArray()->all(), 'id', 'district'),
                [
                    'id' => 'district_id',
                    'prompt' => Yii::t('frontend', 'Select District'),
                    'onchange' => '
                            $.post( "' . Url::to(['/s-geo-sector/lists', 'id' => '']) . '"+$(this).val(),function(data){
                            $("#sector_id" ).html(data);
                        });'
                ]
        )->label(Yii::t('frontend', 'District') . ' <sup><span style="color:red">*</span></sup>')
        ?> 

    </div>

    <div class="input-div">
        <?=
        $form->field($address, 'geo_sector_id')->dropDownList(
                ArrayHelper::map(SGeosector::find()->orderBy('sector')->where(['!=', 'district_id', 61])->asArray()->all(), 'id', 'sector'),
                [
                    'id' => 'sector_id',
                    'prompt' => Yii::t('frontend', 'Select Sector')
                ]
        )->label(Yii::t('frontend', 'Sector') . ' <sup><span style="color:red">*</span></sup>')
        ?> 

    </div>
</div>

<div class='input-text'> 
    <div class="input-div">
        <?= $form->field($address, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Phone Number'])->label(Yii::t('frontend', 'Phone Number') . ' <sup><span style="color:red">*</span></sup>'); ?>  
    </div>

    <div class="input-div">
<?= $form->field($address, 'pobox')->textInput(['maxlength' => true, 'placeholder' => 'PoBox']) ?>
    </div>
</div>
<div class='input-text'> 
    <div class="input-div">
<?= $form->field($address, 'physical_address')->textArea(['maxlength' => true, 'placeholder' => 'Physical Address']) ?>
    </div>

</div>





