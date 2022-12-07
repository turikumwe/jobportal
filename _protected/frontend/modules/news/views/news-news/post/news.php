<?php

use common\models\ServiceEvent;
use frontend\assets\FrontendAsset;
use \yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this View */
/* @var $model ServiceEvent */
/* @var $form ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php
    if (Yii::$app->user->can('mediator')) {
        include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    } else {
        include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_navigation.php");
    }
    ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <?php if (!$is_update) {
            ?>
            <h1>Post news</h1>
            <p class="pxp-text-light">Post a news. Fields with <span style="color:red">*</span> are required</p>
            <?php
        } else {
            ?>
            <h1>Update news</h1>
            <p class="pxp-text-light">Update a news. Fields with <span style="color:red">*</span> are required</p>
            <?php
        }
        ?>
        <div class="service-event-form">

            <br>
            <b>Form to Post news </b>
            <hr>


            <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl($url)], ['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->errorSummary($model); ?>

            <div class="col-md-12 mb-3">
                <?=
                $form->field($model, 'news_type')->dropDownList(
                        ArrayHelper::map(array(array('id' => '1', 'label' => 'Internal'), array('id' => '2', 'label' => 'External')), 'id', 'label'),
                        [
                            'id' => 'news_type',
                            'prompt' => Yii::t('app', 'Select type'),
                            'onchange' => 'check_slected(this.value)'
                        ]
                );
                ?>
                <input type="hidden" id="saved_type" value="<?= $model->news_type ?>" />
            </div>
            <div class="col-md-12 mb-3">
                <?= $form->field($model, 'headline')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12 mb-3 for_internal" style="display: none;">
                <?=
                $form->field($model, 'news_details')->widget(TinyMce::class, [
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
            <div class="col-md-12 mb-3 for_external" style="display: none;">
                <?= $form->field($model, Html::encode('link'))->textInput(['maxlength' => true, 'onChange' => 'removeHttps("newsnews-link")']) ?>
            </div>
            <div class="col-md-12 mb-3 for_external" style="display: none;">
                <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12 mb-3">
                <?= $form->field($model, 'publication_date')->dateInput(['maxlength' => true,]) ?>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <?=
                    $form->field($model, 'action_id')->dropDownList(
                            ArrayHelper::map(\backend\models\SActions::find()->asArray()->all(), 'pk_action', 'action'),
                            [
                                'id' => 'action',
                                'prompt' => Yii::t('app', 'Select Action')
                            ]
                    )->label('News status');
                    ?>
                </div>
            </div>
            <hr />
            <?php if (!Yii::$app->request->isAjax) { ?>
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Post news') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>

            <?php } ?>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        if (isNaN(parseInt($('#saved_type').val()))) {
            $('.for_internal').css("display", "none");
            $('.for_external').css("display", "none");
        }
        if (parseInt($('#saved_type').val()) === 1) {
            $('.for_internal').css("display", "block");
            $('.for_external').css("display", "none");
        }
        if (parseInt($('#saved_type').val()) === 2) {
            $('.for_internal').css("display", "none");
            $('.for_external').css("display", "block");
        }
    });
    function check_slected(value) {
        if (value === '1') {
            $('.for_internal').css("display", "block");
            $('.for_external').css("display", "none");
        }
        if (value === '2') {
            $('.for_internal').css("display", "none");
            $('.for_external').css("display", "block");
        }

    }

</script>