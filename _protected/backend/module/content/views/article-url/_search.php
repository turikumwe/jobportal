<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\content\models\ArticleUrlSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="article-url-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'article_id') ?>

    <?php echo $form->field($model, 'url') ?>

    <?php echo $form->field($model, 'name') ?>

    <?php echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'order') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
