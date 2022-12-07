<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\service\models\search\ServiceJobSearch;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceJobSearch */
/* @var $form yii\widgets\ActiveForm */

$model = new ServiceJobSearch();
?>
<div class="panel widget light-widget panel-bd-top">
    <div class="panel-heading"><?= Yii::t("frontend", "Search an opportunity") ?></div>
    <div class="panel-body">
        <div class="form-service-job-search">
            <?php $form = ActiveForm::begin([
                'id' => 'w43',
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'class' => 'search__frm'
                ],
            ]); ?>
            <div class="form-group field-servicejobsearch-jobtitle">
                <?= $form->field($model, 'jobtitle')->textInput(['maxlength' => true, 'placeholder' => Yii::t("frontend", 'Keyword'), 'class' => 'form-control'])->label(false) ?>
                <div class="help-block"></div>
            </div>
            <?= Html::submitButton(Yii::t('frontend', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>