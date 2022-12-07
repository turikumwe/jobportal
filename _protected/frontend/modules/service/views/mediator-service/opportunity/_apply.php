<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
$this->registerJsFile('https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
/* @var $this yii\web\View */
/* @var $model common\models\JsJobApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-event-application-form">

    <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl('/jobseeker/js-event-application/create')]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'even_id')->hiddenInput(['value' => $get->id])->label(false); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>

    <?= $form->field($model, 's_opportunity_id')->hiddenInput(['value' => $opportunity])->label(false) ?>

    <?= $form->field($model, 'motivation')->textarea(['rows' => 6]) ?>

    <?=
    $form->field($model, 'area_of_expertise_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\backend\models\SAreaExpertise::find()->orderBy('expertise')->asArray()->all(), 'id', 'expertise'),
            [
                'id' => 'area_of_expertise_id_' . $get->id,
                'prompt' => Yii::t('app', 'Area of expertise')
    ]);
    ?>
    <?=
    $form->field($model, 'employment_status_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\backend\models\SEmploymentStatus::find()->orderBy('status')->asArray()->all(), 'id', 'status'),
            [
                'id' => 'employment_status_id_' . $get->id,
                'prompt' => Yii::t('app', 'Employment status')
    ]);
    ?>
    <?=
    $form->field($model, 'special_assistance_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\backend\models\SSpecialAssistance::find()->orderBy(['id' => SORT_DESC])->asArray()->all(), 'id', 'assistance'),
            [
                'id' => 'special_assistance_id_' . $get->id,
                'prompt' => Yii::t('app', 'Special assistance')
    ]);
    ?>


    <?php if (!Yii::$app->request->isAjax) {
        ?>
        <hr />
        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit application') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php }
    ?>


<?php ActiveForm::end(); ?>

</div>
