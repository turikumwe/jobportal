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
                $form->field($candidate_model, 'minimum_score')->numberInput(['maxlength' => true,])
                ?>
            </div>
        </div>
        <div class="col-md-5">   
            <div class="mb-3">
                <?=
                $form->field($candidate_model, 'maximum_score')->numberInput(['maxlength' => true,])
                ?>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3">
                <?=
                $form->field($candidate_model, 'status')->dropDownList(
                        ArrayHelper::map(frontend\modules\hr\models\ApiAssessmentCandidate::CANDIDATE_STATUSES, 'id', 'label'),
                        [
                            'prompt' => 'Select status',
                        ]
                );
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Search candidates'), ['class' => 'btn btn-primary']) ?>
            <?php /* echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) */ ?>
            <!-- <span class="pull-right btn btn-info"><a href='/jobseeker/user-profile/more-options'  style="color:white"><b>More options</b></a></span> -->
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <hr />
</div>
