<?php 
use yii\bootstrap\ActiveForm;
use \yii\helpers\ArrayHelper;
use \kartik\widgets\Select2;
use \yii\widgets\ListView;
use yii\bootstrap\Html;
?>
<div class="panel widget light-widget panel-bd-top">
    <div class="panel-heading no-title">
        <center>
        <h4>
            <b>Qualification</b></h4>
        </center> 
    </div>
    <div class="panel-body">
    <?php $form = ActiveForm::begin() ?>
    		<?= $form->field($searchModel, 'education_level_id')->widget(\kartik\widgets\Select2::classname(), [
			        'data' => ArrayHelper::map(\backend\models\SEducationLevel::find()->orderBy('level')->asArray()->all(), 'id', 'level'),
			        'options' => [
			        	'placeholder' => Yii::t('app', 'Qualification'),
			        	'onChange' => 'searchByQualification($(this).val())'
			        ],
			        'pluginOptions' => [
			            'allowClear' => true
			        ],
			    ])->label(false); ?>

    <?php ActiveForm::end() ?>
	</div>
</div>
<script>
    function searchByQualification(value) {
        window.location.href= "/service/service-event/index?type=qualification&search="+value;
    }
</script>