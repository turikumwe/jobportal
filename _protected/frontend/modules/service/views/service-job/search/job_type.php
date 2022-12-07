<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\SJobType;
use yii\widgets\ListView;
use yii\bootstrap\Html;
?>
<div id="job_type" class="panel widget light-widget panel-bd-top">
    <div class="panel-heading">
        <?= Yii::t("frontend","Contract Type") ?>
    </div>
    <div class="panel-body">
    <?php $form = ActiveForm::begin() ?>
    		<?= $form->field($searchModel, 'job_type_id')->widget(\kartik\widgets\Select2::class, [
			        'data' => ArrayHelper::map(SJobType::find()->orderBy('job_type')->asArray()->all(), 'id', 'job_type'),
			        'options' => [
			        	'placeholder' => Yii::t('frontend', 'Job Type'),
			        	'onChange' => 'searchByJobType($(this).val())'
			        ],
			        'pluginOptions' => [
			            'allowClear' => true
			        ],
			    ])->label(false); ?>

    <?php ActiveForm::end() ?>
	</div>
</div>
<script>
    function searchByJobType(value) {
    	let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";
        window.location.href= FRONTEND_BASE_URL+"/service/service-job/index?type=jobtype&search="+value+"#job_type";
    }
</script>