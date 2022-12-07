<?php
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceInternship */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-internship-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    <div class="col-md-6">
    <?= $form->field($model, 'employer')->textInput(['maxlength' => true, 'placeholder' => 'Employer']) ?>        
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'internship_name')->textInput(['maxlength' => true, 'placeholder' => 'Internship name']) ?>        
    </div>    
    <div class="col-md-12">
            <?= $form->field($model, 'employer_description')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
                'language' => 'es',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ]);?>
    </div>
    <div class="col-md-12">
            <?= $form->field($model, 'internship_description')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
                'language' => 'es',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ]);?>
    </div>
    <div class="col-md-12">
    <?= $form->field($model, 'positions_number')->textInput(['placeholder' => 'Positions number']) ?>        
    </div>    
    <div class="col-md-12">
            <?= $form->field($model, 'intern_duties')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
                'language' => 'es',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ]);?>
    </div>    
    <div class="col-md-12">
            <?= $form->field($model, 'intern_responsability')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
                'language' => 'es',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ]);?>
    </div>    
    <div class="col-md-12">
            <?= $form->field($model, 'intern_skill_requirement')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
                'language' => 'es',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ]);?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'economic_sector_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SIsicr4Level4::find()->orderBy('ecosector')->asArray()->all(), 'id', 'ecosector'),
        'options' => ['placeholder' => Yii::t('app', 'Economic sector')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'education_level_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('level')->asArray()->all(), 'id', 'level'),
        'options' => ['placeholder' => Yii::t('app', 'Education level')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'education_field_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SEducationField::find()->orderBy('field')->asArray()->all(), 'id', 'field'),
        'options' => ['placeholder' => Yii::t('app', 'Education field')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>        
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'publication_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Publication date'),
                'autoclose' => true
            ]
        ],
    ]); ?>        
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'closure_date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => false,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Closure date'),
                'autoclose' => true
            ]
        ],
    ]); ?>        
    </div>    
    <div class="col-md-12">
            <?= $form->field($model, 'how_to_apply')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
                'language' => 'es',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ]);?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'contact_phone')->textInput(['maxlength' => true, 'placeholder' => 'Contact phone']) ?>            
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true, 'placeholder' => 'Contact email']) ?>
    </div>
   <div class="col-md-12">
            <?= $form->field($model, 'any_further_information')->widget(TinyMce::class, [
                'options' => ['rows' => 6],
                'language' => 'es',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
            ]);?>
    </div>

    <?php /* $form->field($model, 'action_id')->checkbox() */?>
    <div class="col-md-6">
    <?= $form->field($model, 'district_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SDistrict::find()->orderBy('district')->asArray()->all(), 'id', 'district'),
        'options' => ['placeholder' => Yii::t('app', 'District')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    </div>

    <?php /* echo $form->field($model, 'posted')->textInput(['placeholder' => 'Posted']) */?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
