<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
 

/* @var $this yii\web\View */
/* @var $model common\models\JsSkill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kora-container js-skill-form">

    <?php $form = ActiveForm::begin(
        [
            'action' => $url,
             //'enableClientValidation' => true,
             //'enableAjaxValidation' => true,
        ]
    ); ?>

    <?= $form->errorSummary($model); ?>
    <div class="inline__flds">
        <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['id' => 'jsskill-id_' . $id, 'style' => 'display:none']); ?>

        <?= $form->field($model, 'user_id')->hiddenInput(['id' => 'jsskill-user_id_' . $id, 'value' => \Yii::$app->user->id])->label(false) ?>
    </div>
    <div class="inline__flds">
        <div class="input__fld">
            <?= $form->field($model, 'skill_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\models\SSkill::find()->orderBy('id')->asArray()->all(), 'id', 'skill'),
                [
                    'id' => 'skill_level_id_' . $id,
                    'prompt' => Yii::t('app', 'Select Skill type')
                ]
            );
            ?>
        </div>
    </div>
    <div class="inline__flds">
        <div class="input__fld">
            <?= $form->field($model, 'skill_level_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\models\SSkillLevel::find()->orderBy('id')->asArray()->all(), 'id', 'level'),
                [
                    'id' => 'skill_level_id_' . $id,
                    'prompt' => Yii::t('app', 'Select Skill Level')
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