<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\service\models\search\ServiceEventSearch;


$model = new ServiceEventSearch();
?>
<div class="panel widget light-widget panel-bd-top">
    <div class="panel-heading">Search an Event</div>
    <div class="panel-body">
        <div class="form-service-event-search">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'class' => 'search__frm'
                ],
            ]); ?>
            <div class="form-group field-servicejobsearch-jobtitle">
                <?= $form->field($model, 'event_title')->textInput(['maxlength' => true, 'placeholder' => 'Keyword'])->label(false) ?>
                <div class="help-block"></div>
            </div>
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end(); ?>

        </div>

    </div>
</div>