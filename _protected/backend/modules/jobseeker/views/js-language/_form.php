<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsLanguage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-language-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\UserProfile::jobSeekers()->asArray()->all(), 'user_id', 'fullName'),
        'options' => ['placeholder' => Yii::t('app', 'User')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'language')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SLanguage::find()->orderBy('language')->asArray()->all(), 'id', 'language'),
        'options' => ['placeholder' => Yii::t('app', 'Language')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'reading')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SLanguageRating::find()->orderBy('id')->asArray()->all(), 'id', 'languagerate'),
        'options' => ['placeholder' => Yii::t('app', 'Reading rating')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'writing')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SLanguageRating::find()->orderBy('id')->asArray()->all(), 'id', 'languagerate'),
        'options' => ['placeholder' => Yii::t('app', 'Choose S language rating')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'listening')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SLanguageRating::find()->orderBy('id')->asArray()->all(), 'id', 'languagerate'),
        'options' => ['placeholder' => Yii::t('app', 'Writing rating')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'speaking')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\SLanguageRating::find()->orderBy('id')->asArray()->all(), 'id', 'languagerate'),
        'options' => ['placeholder' => Yii::t('app', 'Speaking rating')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>





