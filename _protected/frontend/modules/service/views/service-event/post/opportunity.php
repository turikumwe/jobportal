<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
use backend\models\SDistrict;
use backend\models\SProvince;
use backend\models\SGeosector;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceEvent */
/* @var $form yii\widgets\ActiveForm */

$model->district = SGeosector::findOne($model->event_location)['district_id'];
$model->province = SDistrict::findOne($model->district)['province_id'];
?>

<div class="service-event-form">

    <br>
    <b>Form to Post Event or Training</b>
    <hr>

    <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl($url), 'id'=>'event_form'], ['options' => ['enctype' => 'multipart/form-data',]]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'event_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Training Title'])->label('Training Title') ?>
    </div>


    <div class="col-md-12 mb-3" style="display: none">
        <?= $form->field($model, 's_opportunity_id')->hiddenInput(['value' => '1'])->label(false); ?>

    </div>

    <div class="col-md-12 mb-3">
        <?=
        $form->field($model, 'description_organiser')->widget(TinyMce::class, [
            'options' => ['rows' => 6],
            'language' => 'en',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            ]
        ]);
        ?>

    </div>

    <div class="col-md-12 mb-3">
        <?=
        $form->field($model, 'description_event')->widget(TinyMce::class, [
            'options' => ['rows' => 6],
            'language' => 'en',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            ]
        ])->label('Training description');
        ?>
    </div>
    <div class="col-md-12 mb-3" style="display: none">
        <?=
        $form->field($model, 'qualification_participant')->widget(TinyMce::class, [
            'options' => ['rows' => 6],
            'language' => 'en',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            ]
        ]);
        ?>
    </div>

    <div class="col-md-12 mb-3" style="display: none">
        <?=
        $form->field($model, 'event_requirement')->widget(TinyMce::class, [
            'options' => ['rows' => 6],
            'language' => 'en',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            ]
        ]);
        ?>
    </div>

    <div class="col-md-12 mb-3" style="display: none">
        <?=
        $form->field($model, 'event_summary')->widget(TinyMce::class, [
            'options' => ['rows' => 6],
            'language' => 'en',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            ]
        ]);
        ?>
    </div>



    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'number_participant')->textInput(['maxlength' => true, 'placeholder' => 'Enter Number of Participants']) ?>
    </div>

    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'venue')->textInput(['maxlength' => true, 'placeholder' => 'Enter traning Venue'])->label('Training Venue'); ?>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <?=
            $form->field($model, 'province')->dropDownList(
                    ArrayHelper::map(SProvince::form(), 'id', 'province'),
                    [
                        'prompt' => Yii::t('app', 'Select Province'),
                        'onchange' => '
                    $.post( "' . Url::to(['/s-district/lists', 'id' => '']) . '"+$(this).val(),function(data){
                        $("#event_district").html(data);
                    });'
                    ]
            );
            ?>
        </div>

        <div class="col-md-4 mb-3"   >
            <?=
            $form->field($model, 'district')->dropDownList(
                    ArrayHelper::map(SDistrict::find()->orderBy('district')->asArray()->all(), 'id', 'district'),
                    [
                        'id' => 'event_district',
                        'prompt' => Yii::t('app', 'Select District'),
                        'onchange' => '
                        $.post( "' . Url::to(['/s-geo-sector/lists', 'id' => '']) . '"+$(this).val(),function(data){
                            $("#event_sector").html(data);
                        });'
                    ]
            );
            ?>
        </div>

        <div class="col-md-4 mb-3">
            <?=
            $form->field($model, 'event_location')->dropDownList(
                    ArrayHelper::map(SGeosector::find()->orderBy('sector')->asArray()->all(), 'id', 'sector'),
                    [
                        'id' => 'event_sector',
                        'prompt' => Yii::t('app', 'Select Sector')
                    ]
            );
            ?>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'start_date')->dateInput(['maxlength' => true,]) ?>

    </div>

    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'end_date')->dateInput(['maxlength' => true,]) ?>

    </div>

    <div class="col-md-12 mb-3" style="display: none">
        <?=
        $form->field($model, 'how_to_apply')->widget(TinyMce::class, [
            'options' => ['rows' => 6],
            'language' => 'en',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            ]
        ]);
        ?>
    </div>
    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'docFile')->fileInput(); ?>
    </div>
    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'apply_through_kora_flag')->checkbox(['value' => 1]) ?>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'closure_date')->dateInput(['maxlength' => true,]) ?>

        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group field-serviceevent-apply_through_kora_flag required">
                <br />
                <label><?= $form->field($model, 'always_open_flag')->checkbox() ?>
                
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <?=
            $form->field($model, 'action_id')->dropDownList(
                    ArrayHelper::map(\backend\models\SActions::find()->asArray()->all(), 'pk_action', 'action'),
                    [
                        'id' => 'action',
                        'prompt' => Yii::t('app', 'Select Action')
                    ]
            );
            ?>
        </div>
    </div>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
