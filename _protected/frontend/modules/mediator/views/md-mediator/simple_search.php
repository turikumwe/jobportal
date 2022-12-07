
<?php 
use common\models\MdMediator;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
?>

<div class="panel widget light-widget panel-bd-top" >
<div class="panel-heading"><?= Yii::t("frontend","Search a Mediator") ?></div>
    <div class="panel-body">
        <?=
        	AutoComplete::widget([
	            'name' => 'grobal_search',
	            'id' => 'mediator',
	            'clientOptions' => [
	            'source' => MdMediator::data(),
	            'autoFill'=>true,
	            'minLength'=>'1',
            'select' => new JsExpression("function( event, ui ) {
                searchMediator($('#mediator').val(ui.item.id).val());
             }")],
            'options' => [
                'placeholder' => 'Search a mediator institution as you type ...',
            ]
        ])
       ?>
    </div>
</div>