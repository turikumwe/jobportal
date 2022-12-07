<?php 
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use common\models\UserProfile;
?>
<div class="panel widget light-widget panel-bd-top" >
<div class="panel-heading no-title"><center><b>Search a Member</b></center> </div>
    <div class="panel-body">
        <?=
        	AutoComplete::widget([
            'name' => 'grobal_search',
            'id' => 'profile',
            'clientOptions' => [
            'source' => UserProfile::data(),
            'autoFill'=>true,
            'minLength'=>'1',
            'select' => new JsExpression("function( event, ui ) {
                search($('#profile').val(ui.item.id).val());
             }")],
            'options' => [
                'placeholder' => 'Search a member as you type ...',
            ]
             ])
       ?>
    </div>
</div>