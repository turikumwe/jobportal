<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsEndorse */
/* @var $form yii\widgets\ActiveForm */
$user_id = (isset($_GET['js'])) ? $_GET['js'] : 0;
?>

<div class="js-endorse-form">

    <?php
    $form = ActiveForm::begin(
                    [
                        'action' => $url,
                    //'enableClientValidation' => false,
                    //'enableAjaxValidation' => true,
                    ]
    );
    ?> 

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \common\models\UserProfile::findUserIdByUser($user_id)])->label(false); ?>

    <?=
    $form->field($model, 'skill_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\backend\models\SSkill::find()->orderBy('id')->asArray()->all(), 'id', 'skill'),
            [
                'id' => 'skill_level_id_',
                'prompt' => Yii::t('app', 'Select Skill type')
            ]
    );
    ?>
    <?= $form->field($model, 'who_endorsed_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>


    <?php ActiveForm::end(); ?>

</div>
