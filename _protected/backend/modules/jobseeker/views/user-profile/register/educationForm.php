<?php
use trntv\filekit\widget\Upload;
?>


<?php \kak\widgets\fieldset\FieldSet::begin([
    'legend' => Yii::t('app-dash','<i class="glyphicon glyphicon-user"></i>Highest education level'),
    'active' => true, // false - hide content, default true
    'speed'  => 0, // animation speed default value 300
    'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
    'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
]);?>

 <div class="col-md-4">
    <?= Yii::$app->label::helper($education,'education_level_id')?>
    <?= $form->field($education, 'education_level_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('id')->asArray()->all(), 'id', 'level'),
        'options' => [
            'placeholder' => 'Education level',
            'onchange'=>'

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
    ])->label(false); ?>   
 </div>
<div id="other">
 <div class="col-md-4">
    <?= Yii::$app->label::helper($education,'education_field_id')?>
    <?= $form->field($education, 'education_field_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('id')->asArray()->all(), 'id', 'field'),
        'options' => ['id' => 'jseducation-education_field_id' , 'placeholder' => 'Education field'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(false); ?> 
 </div>
<div class="col-md-4">
    <?= Yii::$app->label::helper($education,'grade_id')?>
    <?= $form->field($education, 'grade_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SGrade::find()->orderBy('id')->asArray()->all(), 'id', 'grade'),
        'options' => ['id' => 'jseducation-grade_id' , 'placeholder' => 'Grade'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(false); ?>  
 </div>


<div class="row">
<div class="col-md-4">
    <?= Yii::$app->label::helper($education,'school')?>
    <?= $form->field($education, 'school')->textInput(['maxlength' => true, 'placeholder' => 'School'])->label(false) ?>  
 </div>
<div class="col-md-4">
  <?= $form->field($education, 'country_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('id')->asArray()->all(), 'id', 'cc_description'),
        'options' => ['id' => 'jseducation-country_id' ,'placeholder' => 'Country'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>   
 </div>

 <div class="col-md-4">
    <?= Yii::$app->label::helper($education,'exact_quali')?>
    <?= $form->field($education, 'exact_quali')->textInput(['maxlength' => true, 'placeholder' => 'Exact qualification'])->label(false) ?>  
 </div>



</div>

<div class="row">
<div class="col-md-4">
    <?= $form->field($education, 'graduation_date')->dropDownList($education->years(),
                            [
                                'options' => ['id'=> 'jseducation-graduation_date', 'placeholder' => 'Select Graduation Year' ]
                                ])
    ?>
 </div>

 <div class="col-md-4">
    <?= Yii::$app->label::helper($education,'certificate_id')?>
    <?= $form->field($education, 'certificate_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCertificate::find()->orderBy('id')->asArray()->all(), 'id', 'certificate'),
        'options' => ['id' => 'jseducation-certificate_id' ,'placeholder' => 'Certificate'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(false); ?>  
 </div>

 
 <div class="col-md-4">
    <?= Yii::$app->label::helper($education,'certificateFile')?>
    <?php echo $form->field($education, 'certificateFile')->widget(
                            Upload::class,
                            [
                                'url' => ['/jobseeker/js-education/certificate-upload']
                            ]
                )->label(false) ?>  
 </div>
</div>
</div>
</div>

</div>

<?php \kak\widgets\fieldset\FieldSet::end(); ?>