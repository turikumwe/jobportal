<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\SEventCategory;
use yii\widgets\ListView;
use yii\bootstrap\Html;
?>
<div id="event_type" class="panel widget light-widget panel-bd-top">
    <div class="panel-heading no-title">
        <center><h4><b>Event Type</b></h4></center> 
    </div>
    <div class="panel-body">
    <?php $form = ActiveForm::begin() ?>
    		<?= $form->field($searchModel, 'event_category_id')->widget(\kartik\widgets\Select2::class, [
			        'data' => ArrayHelper::map(SEventCategory::find()->orderBy('category')->asArray()->all(), 'id', 'category'),
			        'options' => [
			        	'placeholder' => Yii::t('app', 'Event Type'),
			        	'onChange' => 'searchByEventType($(this).val())'
			        ],
			        'pluginOptions' => [
			            'allowClear' => true
			        ],
			    ])->label(false); ?>

    <?php ActiveForm::end() ?>
	</div>
</div>
<script>
    function searchByEventType(value) {
        window.location.href= "/service/service-event/index?type=type&search="+value+"#event_type";
    }
</script>