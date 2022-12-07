<?php

use common\models\JsAddress;
use common\models\JsEducation;
use common\models\JsExperience;
use common\models\JsLanguage;
use common\models\JsSkill;
use common\models\JsSummary;
use common\models\JsTraining;
use common\models\ServiceEvent;
use common\models\ServiceJob;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model ServiceEvent */
/* @var $form ActiveForm */
?>

<div class="service-event-form">
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <strong><i class="icon fa fa-close"></i>Error!</strong> <?= Yii::$app->session->getFlash('error') ?>
            <a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: red">&times;</a>
        </div>
    <?php endif; ?>
    <br>
    <b>Form to record as offered service</b>
    <hr>


    <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl($url)]); ?>
    <?= $form->field($model, 'mediator_id')->hiddenInput(['value' => $mediator->id, 'id' => 'mediator_id' . $model->id])->label(false); ?>
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    <div class="col-md-12 mb-3">
        <div class="form-group field-servicejob-education_level_id">
            <label for="pxp-company-job-category" class="form-label">Jobseeker(s)</label>
            <select class="form-control select2" multiple="" data-placeholder="Select jobseekers" tabindex="-1" aria-hidden="true" name="user_ids[]">
                <?php
                if (count($users) > 0) {           // $summary = New JsSummary();
                    foreach ($users as $user) {

                        $summary = JsSummary::find()->where(['user_id' => $user['id']])->count();
                        $experience = JsExperience::find()->where(['user_id' => $user['id']])->count();
                        $education = JsEducation::find()->where(['user_id' => $user['id']])->count();
                        $training = JsTraining::find()->where(['user_id' => $user['id']])->count();
                        $language = JsLanguage::find()->where(['user_id' => $user['id']])->count();
                        $skill = JsSkill::find()->where(['user_id' => $user['id']])->count();
                        $address = JsAddress::find()->where(['user_id' => $user['id']])->count();

                        $oppforabroad = ServiceJob::find()
                                ->where(['competency_level_id' => 2])
                                ->andWhere(['action_id' => 1])
                                ->andWhere(['>=', 'closure_date', date('Y-m-d')])
                                ->count();

                        $completed = array();
                        if ($summary >= 1)
                            $completed[] = "Summary <span class='glyphicon glyphicon-ok'></span>";
                        if ($experience >= 1)
                            $completed[] = "Professional experience ($experience) <span class='glyphicon glyphicon-ok'></span>";
                        if ($education >= 1)
                            $completed[] = "Education ($education) <span class='glyphicon glyphicon-ok'></span>";
                        if ($training >= 1)
                            $completed[] = "Training ($training) <span class='glyphicon glyphicon-ok'></span>";
                        if ($language >= 1)
                            $completed[] = "Language ($language) <span class='glyphicon glyphicon-ok'></span>";
                        if ($skill >= 1)
                            $completed[] = "Skill ($skill) <span class='glyphicon glyphicon-ok'></span>";

                        if ($address >= 1) {
                            $completed[] = "Address <span class='glyphicon glyphicon-ok'></span>";
                            $addresses = JsAddress::find()->where(['user_id' => $user['id']])->one();
                        }

                        $profile = count($completed);
                        $completion_percentage = number_format(($profile * 100 / 7), 1);
                        ?>
                        <option value='<?= $user['id']; ?>' <?= (in_array($user['id'], $selected_users)) ? 'selected' : '' ?>><?= $user['names'] . ' (' . $completion_percentage . '%)'; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <?=
        $form->field($model, 'service_id')->dropDownList(
                ArrayHelper::map($services, 'id', 'name'),
                [
                    'prompt' => 'Select Service', 'onchange' => 'check_service(this.value)'
                ],
        );
        ?>
        <input type="hidden" id="is_placement_service" value="<?= $is_placement_service ?>" />
    </div>
    <div class="row" id="placement_institution" style="display: none;">
        <div class="col-md-12 mb-3">
            <?= $form->field($model, 'institution')->textInput(['maxlength' => true, 'placeholder' => 'Enter the institution']) ?>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'service_date')->dateInput(['maxlength' => true,]) ?>

    </div>

    <div class="col-md-12 mb-3">
        <?= $form->field($model, 'service_description')->textInput(['maxlength' => true, 'placeholder' => 'Enter some description']) ?>
    </div>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        if (parseInt($('#is_placement_service').val()) === 1) {
            $('#placement_institution').css("display", "block");
        }
    });
    function check_service(service_id) {
        $.ajax({
            url: '<?php echo Yii::$app->link->frontendUrl('/service/api/check-service') ?>',
            type: 'post',
            data: {
                id: service_id
            },
            dataType: 'json',
            success: function (response) {
                if (response.success === true) {
                    $('#placement_institution').css("display", "block");
                } else {
                    $('#placement_institution').css("display", "none");
                    $('#mediatorjobseekerservice-institution').val("");
                }
            }
        });
    }

</script>