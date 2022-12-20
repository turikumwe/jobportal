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

    <?php
    $form = ActiveForm::begin([
                'action' => Yii::$app->link->frontendUrl('/hr/assessments/view?id=' . $_GET['id']),
                'method' => 'get',
    ]);
    ?>
    <div class="row">
        <div class="col-md-5">
            <div class="mb-3">
                <?=
                $form->field($model, 'education_level_id')->dropDownList(
                        ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('level')->asArray()->all(), 'id', 'level'),
                        [
                            'prompt' => 'Choose Education level',
                        ]
                );
                ?>
            </div>
        </div>

        <div class="col-md-5">
            <div class="mb-3">
                <?=
                $form->field($model, 'education_field_id')->dropDownList(
                        ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('field')->asArray()->all(), 'id', 'field'),
                        [
                            'prompt' => 'Choose Education Field',
                        ]
                );
                ?>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3">
                <?=
                $form->field($model, 'graduation_date')->dropDownList(
                        ArrayHelper::map(\common\models\JsEducation::find()->asArray()->distinct()->all(), 'graduation_date', 'graduation_date'),
                        [
                            'prompt' => 'Choose Graduation Year',
                        ]
                );
                ?>
            </div>
        </div>


        <div class="col-md-5">
            <div class="mb-3">
                <?=
                $form->field($model, 'disability_id')->dropDownList(
                        ArrayHelper::map(\backend\models\SDisability::find()->orderBy('disability')->asArray()->all(), 'id', 'disability'),
                        [
                            'prompt' => 'Choose disability',
                        ]
                );
                ?>   
            </div>
        </div>

        <div class="col-md-5">
            <div class="mb-3">
                <?=
                $form->field($model, 'iscolevel1_id')->dropDownList(
                        ArrayHelper::map(SIsco08Level1::find()->all(), 'id', 'cat1_description'),
                        [
                            'prompt' => 'Occupation level',
                        ]
                );
                ?>
            </div>
        </div>

        <div class="col-md-5">
            <div class="mb-3">
                <?=
                $form->field($model, 'country_id')->dropDownList(
                        ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('cc_description')->asArray()->all(), 'id', 'cc_description'),
                        [
                            'prompt' => 'Select country',
                        ]
                );
                ?>
            </div>
        </div>

        <div class="col-md-5"> 
            <div class="mb-3">
                <?=
                $form->field($model, 'registration_start')->dateInput(['maxlength' => true,])
                ?>
            </div>
        </div>
        <div class="col-md-5"> 
            <div class="mb-3">
                <?=
                $form->field($model, 'registration_end')->dateInput(['maxlength' => true,])
                ?>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3">
                <?=
                $form->field($model, 'gender')->dropDownlist([
                    '' => 'Select a Gender',
                    UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
                    UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
                ])
                ?> 
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3">
                <?=
                $form->field($model, 'email')->textInput(['maxlength' => true,])
                ?>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3">
                <?=
                $form->field($model, 'phone_number')->textInput(['maxlength' => true,])
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Search job seekers'), ['class' => 'btn btn-primary']) ?>
            <?php /* echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) */ ?>
            <!-- <span class="pull-right btn btn-info"><a href='/jobseeker/user-profile/more-options'  style="color:white"><b>More options</b></a></span> -->
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <hr />
</div>
