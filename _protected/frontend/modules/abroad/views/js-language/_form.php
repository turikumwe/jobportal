<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JsLanguage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="js-language-form">

    <?php $form = ActiveForm::begin(
        [
            'action' => $url,
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
        ]
    ); ?> 

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['id' => 'jslanguage-id_'.$id,'style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['id' => 'jslanguage-user_id_'.$id,'value' => \Yii::$app->user->id])->label(false) ?>
    
    <?= $form->field($model, 'language')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\SLanguage::find()->orderBy('language')->asArray()->all(), 'id', 'language'),
        ['id' => 'language_'.$id, 'prompt' => Yii::t('app', 'Select Language')]); 
    ?>

    <?= $form->field($model, 'reading')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\SLanguageRating::find()->orderBy('id')->asArray()->all(), 'id', 'languagerate'),
        ['id' => 'reading_'.$id,'prompt' => Yii::t('app', 'Select Reading Level')]); 
    ?>

    <?= $form->field($model, 'writing')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\SLanguageRating::find()->orderBy('id')->asArray()->all(), 'id', 'languagerate'),
        ['id' => 'writing_'.$id, 'prompt' => Yii::t('app', 'Select Writing Level')])
    ?>

    <?= $form->field($model, 'listening')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\SLanguageRating::find()->orderBy('id')->asArray()->all(), 'id', 'languagerate'),
        ['id' => 'listening_'.$id, 'prompt' => Yii::t('app', 'Select Listening Level')]); 
    ?>

    <?= $form->field($model, 'speaking')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\SLanguageRating::find()->orderBy('id')->asArray()->all(), 'id', 'languagerate'),
        ['id' => 'speaking_'.$id, 'prompt' => Yii::t('app', 'Select Speaking Level')]); 
    ?>
    
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
