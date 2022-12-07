
<?php 
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use common\models\EmplEmployer;
?>

<div class="panel widget light-widget" >
<div class="panel-heading"><?= Yii::t('frontend','Search a company') ?></div>
    <div class="panel-body">
        <?=
        	AutoComplete::widget([
	            'name' => 'grobal_search',
	            'id' => 'employer',
	            'clientOptions' => [
	            'source' => EmplEmployer::data(),
	            'autoFill'=>true,
	            'minLength'=>'1',
            'select' => new JsExpression("function( event, ui ) {
                searchEmployer($('#employer').val(ui.item.id).val());
             }")],
            'options' => [
                'placeholder' => 'Search an employer as you type ...',
            ]
        ])
       ?>
    </div>
</div>