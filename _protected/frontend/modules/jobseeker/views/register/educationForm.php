<?php

use trntv\filekit\widget\Upload;
?>


<fieldset class="well">
   
    <div id="other">
        <div class="input-text">
            <div class="input-div">
                <?php //echo Yii::$app->label::helper($education, 'education_level_id') 
                ?>
                <?= $form->field($education, 'education_level_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('id')->asArray()->all(), 'id', 'level'),
                    [
                        'prompt' => Yii::t('frontend', 'Select Education Level'),
                        'onchange' => '
                            if($(this).val()==1){
                                $("#other" ).hide();
                                $("#jseducation-school").val("");
                                $("#jseducation-grade_id").val("");
                                $("#jseducation-country_id").val("");
                                $("#jseducation-exact_quali").val("");
                                $("#jseducation-certificatefile").val("");
                                $("#jseducation-graduation_date").val("");
                                $("#jseducation-certificateFile").val(""); 
                                $("#jseducation-education_field_id").val("")
                            } else{
                                $("#other" ).show();
                            }
                        '
                    ]
                )->label(Yii::t('frontend', 'Education Level') . ' <sup><span style="color:red">*</span></sup>') ?> 
            </div>
            <div class="input-div">
                <?php //echo Yii::$app->label::helper($education, 'education_field_id') 
                ?>
                <?= $form->field($education, 'education_field_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('id')->asArray()->all(), 'id', 'field'),
                    [
                        'id' => 'jseducation-education_field_id',
                        'prompt' => Yii::t('frontend', 'Select Education Field')
                    ]
                )->label(Yii::t('frontend', 'Education Field') . ' <sup><span style="color:red">*</span></sup>') ?> 
            </div></div>
             <div class="input-text">
            <div class="input-div">
                <?php //echo Yii::$app->label::helper($education, 'grade_id') 
                ?>
                <?= $form->field($education, 'grade_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SGrade::find()->orderBy('id')->asArray()->all(), 'id', 'grade'),
                    ['id' => 'jseducation-grade_id', 'prompt' => Yii::t('frontend', 'Select Grade')]
                )
                ?>
            </div>
         
            <div class="input-div">
                <?php //echo Yii::$app->label::helper($education, 'school') 
                ?>
                <?= $form->field($education, 'school')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Enter School')]) ?>
            </div></div>
             <div class="input-text">
            <div class="input-div">
                <?= $form->field($education, 'country_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('id')->asArray()->all(), 'id', 'cc_description'),
                    ['id' => 'jseducation-country_id', 'prompt' => Yii::t('frontend', 'Select Country')]
                )
                ?>
            </div>
            <div class="input-div">
                <?php //echo Yii::$app->label::helper($education, 'exact_quali') 
                ?>
                <?= $form->field($education, 'exact_quali')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Enter Exact Qualification')]) ?>
            </div>
        </div>
        <div class="input-text">
            <div class="input-div">
                <?= $form->field($education, 'graduation_date')->dropDownList(
                    $education->years(),
                    [
                        'options' => [
                            'id' => 'jseducation-graduation_date',
                            'placeholder' => Yii::t('frontend', 'Select Graduation Year')
                        ]
                    ]
                )
                ?>
            </div>

            <div class="input-div">
                <?php //echo Yii::$app->label::helper($education, 'certificate_id') 
                ?>
                <?= $form->field($education, 'certificate_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SCertificate::find()->orderBy('id')->asArray()->all(), 'id', 'certificate'),
                    [
                        'id' => 'jseducation-certificate_id',
                        'prompt' => Yii::t('frontend', 'Select Certificate')
                    ]
                )
                ?>
            </div>
            </div>
             
            <div class="input-div">
                <?php //echo Yii::$app->label::helper($education, 'certificateFile') 
                ?>
                <?php
                // echo $form->field($education, 'certificateFile')->widget(
                // Upload::class,
                // [
                //     'url' => ['/jobseeker/js-education/certificate-upload'],
                //     'maxFileSize' => 2 * 1024 * 1024, // 2MB
                //     'maxNumberOfFiles' => 1,
                //     'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(pdf)$/i'),
                // ]
                // )->label(false) 
                echo $form->field($education, 'certificateFile')->fileInput();
                ?>
                <span class="tip">Only PDF file is accepted</span> |
                <span class="tip">Maximum file size is 2MB</span>
            </div> 
        </div>
   
</fieldset>