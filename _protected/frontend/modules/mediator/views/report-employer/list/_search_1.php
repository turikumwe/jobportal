<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use Common\models\UserProfile;
use backend\models\SIsco08Level1;
use backend\models\SIsco08Level2;
use backend\models\SIsco08Level3;
/* @var $this yii\web\View */
/* @var $model AssessmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-user-profile-search">

    <?php $form = ActiveForm::begin([
        'action' => [''],
        'method' => 'get',
    ]); ?>
<div class="row">
    <div class="col-md-5">
        <?= $form->field($model, 'mediator_id')->widget(\kartik\widgets\Select2::class, [
            'data' => ArrayHelper::map(\common\models\MdMediator::find()->orderBy('madiator_name')->asArray()->all(), 'id', 'madiator_name'),
            'options' => ['placeholder' => 'Choose Employment Service Center'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>
    <div class="col-md-5">
        <?= $form->field($model, 'education_level_id')->widget(\kartik\widgets\Select2::class, [
            'data' => ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('level')->asArray()->all(), 'id', 'level'),
            'options' => ['placeholder' => 'Choose Education level'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>

    <div class="col-md-5">
        <?= $form->field($model, 'education_field_id')->widget(\kartik\widgets\Select2::class, [
                'data' => ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('field')->asArray()->all(), 'id', 'field'),
                'options' => ['placeholder' => 'Choose Education Field'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
    </div>
    <div class="col-md-5">
        <?= $form->field($model, 'graduation_date')->widget(\kartik\widgets\Select2::class, [
                'data' => ArrayHelper::map(\common\models\JsEducation::find()->asArray()->distinct()->all(), 'graduation_date', 'graduation_date'),
                'options' => ['placeholder' => 'Choose Graduation Year'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
    </div>


    <div class="col-md-5">
        <?= $form->field($model, 'disability_id')->widget(\kartik\widgets\Select2::class, [
            'data' => ArrayHelper::map(\backend\models\SDisability::find()->orderBy('disability')->asArray()->all(), 'id', 'disability'),
            'options' => ['placeholder' => Yii::t('app', 'disability')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>   
    </div>

    <div class="col-md-5"> 
        <?= $form->field($model, 'iscolevel1_id')->widget(\kartik\widgets\select2::class,[
                        'data'=>ArrayHelper::map(SIsco08Level1::find()->all(),'id','cat1_description'),
                        'theme' => \kartik\widgets\Select2::THEME_KRAJEE, 
                        'options'=>[
                            'placeholder'=>'Occupation level 1',
                            'onchange'=>'
                                
                                $.post("'.Url::to(['../s-isco08-level2/lists', 'id'=> '']).'"+$(this).val(),function(data){
                                     $("select#userprofilesearch-iscolevel2_id" ).html(data);
                                });'
                        ],
                        'language' => 'en',
                        'pluginOptions'=>['alloweClear'=>true],
                        ]);
        ?>
    </div>
    <div class="col-md-5">  
        <?= $form->field($model, 'iscolevel2_id')->widget(\kartik\widgets\select2::class,[
                        'data'=>ArrayHelper::map(SIsco08Level2::find()->where('level1_id=0')->all(),'id','cat2_description'),
                        'theme' => \kartik\widgets\Select2::THEME_KRAJEE, 
                        'options'=>[
                            'placeholder'=>'Occupation level 2',
                            'onchange'=>'
                                
                                $.post("'.Url::to(['../s-isco08-level3/lists', 'id'=> '']).'"+$(this).val(),function(data){
                                     $("select#userprofilesearch-iscolevel3_id" ).html(data);
                                });'
                        ],
                        'language' => 'en',
                        'pluginOptions'=>['alloweClear'=>true],
                        ]);
        ?>   
    </div>

    <div class="col-md-5">   
        <?= $form->field($model, 'iscolevel3_id')->widget(\kartik\widgets\select2::class,[
                        'data'=>ArrayHelper::map(SIsco08Level3::find()->where('level2_id=0')->all(),'id','cat3_description'),
                        'theme' => \kartik\widgets\Select2::THEME_KRAJEE, 
                        'options'=>[
                            'placeholder'=>'Occupation level 3',
                            'onchange'=>'
                                
                                $.post("'.Url::to(['../s-isco08-level4/lists', 'id'=> '']).'"+$(this).val(),function(data){
                                     $("select#userprofilesearch-occupation_id" ).html(data);
                                });'
                        ],
                        'language' => 'en',
                        'pluginOptions'=>['alloweClear'=>true],
                        ]);
        ?>  
    </div>

    <div class="col-md-5">   
        <?= $form->field($model, 'occupation_id')->widget(\kartik\widgets\Select2::class, [
        'data' => ArrayHelper::map(\backend\models\SIsco08Level4::find()->where('level3_id=0')->orderBy('occupation')->asArray()->all(), 'id', 'occupation'),
        'options' => ['placeholder' => Yii::t('app', 'Occupation level 4')],
        'pluginOptions' => [
            'allowClear' => true
        ],
        ]); ?>  
    </div>
    <div class="col-md-5">
        <?= $form->field($model, 'country_id')->widget(\kartik\widgets\Select2::class, [
                'data' => ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('cc_description')->asArray()->all(), 'id', 'cc_description'),
                'options' => ['placeholder' => 'Country'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
    </div>
    <div class="col-md-5">
        <?= $form->field($model, 'province_id')->widget(\kartik\widgets\Select2::class, [
                'data' => ArrayHelper::map(\backend\models\SProvince::find()->orderBy('province')->asArray()->all(), 'id', 'province'),
                'options' => ['placeholder' => 'Province'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
    </div>
    <div class="col-md-5">
        <?= $form->field($model, 'district_id')->widget(\kartik\widgets\Select2::class, [
                'data' => ArrayHelper::map(\backend\models\SDistrict::find()->orderBy('district')->asArray()->all(), 'id', 'district'),
                'options' => ['placeholder' => 'District'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
    </div>
    <div class="col-md-5">   
        <?= $form->field($model, 'registration_start')->widget(\kartik\datecontrol\DateControl::class, [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'From',
                        'autoclose' => true
                    ]
                ],
            ]); ?>
    </div>

    <div class="col-md-5">
        <?= $form->field($model, 'registration_end')->widget(\kartik\datecontrol\DateControl::class, [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'To',
                        'autoclose' => true
                    ]
                ],
            ]); ?>
    </div>
    <div class="col-md-5">
        <?= $form->field($model, 'gender')->dropDownlist([
                '' => 'Select a Gender',
                UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
                UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
            ]) 
        ?> 
    </div>
</div>

<div class="row">
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php /*echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) */?>
        <!-- <span class="pull-right btn btn-info"><a href='/jobseeker/user-profile/more-options'  style="color:white"><b>More options</b></a></span> -->
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
