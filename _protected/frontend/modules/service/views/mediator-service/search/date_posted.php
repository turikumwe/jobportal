<?php 
use yii\bootstrap\ActiveForm;
use \yii\widgets\ListView;
use yii\bootstrap\Html;
?>
<div class="panel widget light-widget panel-bd-top">
    <div class="panel-heading">
        Date Posted
    </div>
    <div class="panel-body">
    <?php $form = ActiveForm::begin() ?>
		        <?= $form->field($searchModel, 'date_posted')
                    ->dropDownList($searchModel->getDateRangeOptions(), [
                        'prompt' => Yii::t('frontend', 'Select'),
                        'onChange' => 'searchByDatePosted($(this).val())'
                    ])
                    ->label(false)
                ?>
    <?php ActiveForm::end() ?>
	</div>
</div>
<script>
    function searchByDatePosted(value) {
        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>"; 
        window.location.href= FRONTEND_BASE_URL+"/service/service-event/index?type=dateposted&search="+value;
    }
</script>