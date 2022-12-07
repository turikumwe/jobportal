<?php

use trntv\filekit\widget\Upload;
?>


<?php \kak\widgets\fieldset\FieldSet::begin([
    'legend' => '<i class="glyphicon glyphicon-user"></i> ' . Yii::t('frontend', 'Highest education level & CV'),
    'active' => true, // false - hide content, default true
    'speed'  => 0, // animation speed default value 300
    'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
    'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
]); ?>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($education, 'education_level_id')->widget(\kartik\widgets\Select2::class, [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('id')->asArray()->andWhere(['status' => 1])->orderBy(['order' => SORT_ASC])->all(), 'id', 'level'),
            'options' => [
                'placeholder' => Yii::t('frontend', 'Select Education Level'),
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
                }'

            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($education, 'education_field_id')->widget(\kartik\widgets\Select2::class, [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('id')->asArray()->all(), 'id', 'field'),
            'options' => ['id' => 'jseducation-education_field_id', 'placeholder' => Yii::t('frontend', 'Select Academic specialization')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($education, 'exact_quali')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Enter Exact Major')]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php
            echo "<b>CV</b>";
            // echo $form->field($summary, 'cvFile')->widget(
            //     Upload::class,
            //     [
            //         'url' => ['/jobseeker/js-summary/cv-upload'],
            //         'sortable' => true,
            //         'maxFileSize' => 2 * 1024 * 1024, //5M
            //         'maxNumberOfFiles' => 1,
            //         'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(pdf)$/i'),
            //     ]
            // );
            echo $form->field($summary, 'cvFile')->fileInput()->label(false);
        ?>
        <span style="font-size: 12px;font-style: italic">Only PDF file is accepted</span> |
        <span style="font-size: 12px;font-style: italic">Maximum file size is 2MB</span>
    </div>
</div>

<?php \kak\widgets\fieldset\FieldSet::end(); ?>