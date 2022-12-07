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

<div class='row'> 
 <div class="col-md-4">
   <?= $form->field($education, 'school')->textInput(['maxlength' => true, 'placeholder' => 'School']) ?>  
 </div>
 <div class="col-md-4">
  <?= $form->field($education, 'country_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('id')->asArray()->all(), 'id', 'cc_description'),
        'options' => ['placeholder' => 'Country'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>   
 </div>
 <div class="col-md-4">
  <?= $form->field($education, 'education_level_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('id')->asArray()->all(), 'id', 'level'),
        'options' => ['placeholder' => 'Education level'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>   
 </div>
</div>

<div class='row'> 
 <div class="col-md-4">
    <?= $form->field($education, 'education_field_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('id')->asArray()->all(), 'id', 'field'),
        'options' => ['placeholder' => 'Education field'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?> 
 </div>
 <div class="col-md-4">
   <?= $form->field($education, 'exact_quali')->textInput(['maxlength' => true, 'placeholder' => 'Exact qualification']) ?>  
 </div>
 <div class="col-md-4">
    <?= $form->field($education, 'start_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Start date',
                'autoclose' => true
            ]
        ],
    ]); ?> 
 </div>
</div>

<div class='row'> 
 <div class="col-md-4">
    <?= $form->field($education, 'end_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'End date',
                'autoclose' => true
            ]
        ],
    ]); ?> 
 </div>
 <div class="col-md-4">
   <?= $form->field($education, 'grade_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SGrade::find()->orderBy('id')->asArray()->all(), 'id', 'grade'),
        'options' => ['placeholder' => 'Grade'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>  
 </div>
 <div class="col-md-4">
    <?= $form->field($education, 'certificate_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCertificate::find()->orderBy('id')->asArray()->all(), 'id', 'certificate'),
        'options' => ['placeholder' => 'Certificate'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>  
 </div>
</div>

<div class='row'> 
 <div class="col-md-4">
    <?php echo $form->field($education, 'certificateFile')->widget(
                            Upload::class,
                            [
                                'url' => ['/jobseeker/js-education/certificate-upload']
                            ]
                )?>  
 </div>
</div>

<?php \kak\widgets\fieldset\FieldSet::end(); ?>