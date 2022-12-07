<?php
use common\models\SInterest;
use backend\models\SNoyes;
?>


<?php \kak\widgets\fieldset\FieldSet::begin([
    'legend' => '<i class="glyphicon glyphicon-user"></i> ' . Yii::t('frontend', 'Interest'),
    'active' => true, // false - hide content, default true
    'speed'  => 0, // animation speed default value 300
    'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
    'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
]); ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($interest, 'interest_id')->widget(\kartik\widgets\Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(SInterest::find()->orderBy('id')->asArray()->all(), 'id', 'interest'),
            'options' => ['placeholder' => Yii::t('frontend', 'Select interest')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($employmentstatus, 'status_id')->widget(\kartik\widgets\Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(SNoyes::find()->orderBy('id')->asArray()->all(), 'id', 'noyes'),
            'options' => ['placeholder' => Yii::t('frontend', 'Select yes or no')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("Are you employed currently?"); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($shareprofile, 'share_id')->widget(\kartik\widgets\Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(SNoyes::find()->orderBy('id')->asArray()->all(), 'id', 'noyes'),
            'options' => ['placeholder' => Yii::t('frontend', 'Select yes or no')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("Do you want your profile to be shown to employers?"); ?>
    </div>
</div>

<?php \kak\widgets\fieldset\FieldSet::end(); ?>