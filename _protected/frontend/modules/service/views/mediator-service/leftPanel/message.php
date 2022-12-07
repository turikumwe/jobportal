<?php 
use yii\helpers\Html;
use yii\bootstrap\Modal;
use common\models\JsMessage;
?>

<div class="panel widget light-widget panel-bd-top">
<div class="panel-heading no-title"> </div>
	<div class="panel-body">
		<table class="table table-striped table-hover">
		<tbody>
			<tr>
				<th colspan="2"><center>Messages</center></th>
			</tr>
			<tr>
				<td style="width:40%;">
					Inbox 
				</td>
				<td align="center">
					<span><?= \common\models\JsMessage::find()->received()->new()->count()?></span>
				</td>
			</tr>
			<tr>
				<td style="width:40%;">
					Sent 
				</td>
				<td align="center">
					<span><?= \common\models\JsMessage::find()->sent()->count()?></span>
				</td>
			</tr>
			<tr>
				<td style="width:40%;">
					Trash 
				</td>
				<td align="center">
					<span><?= \common\models\JsMessage::find()->sent()->deleted()->count()?></span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php if(!isset($_GET['idOtherProfile'])) { 
				   		$messageModel = new JsMessage();
				   	 	Modal::begin([
				   	 		'options' => [
						        'tabindex' => false // important for Select2 to work properly
						    ],
				              'header' => 'Add Message',
				              "class" => "vd_bg-green", 
				              "id"    => "requesr_recommandation",
				              'toggleButton' => [
				              	'class' => 'btn vd_btn btn-xs vd_bg-red',
				              	'label' => 'Request Recommandation'
				              ],
				              'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
				                  //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
				          ]);	                   
				             echo $this->render('/js-message/_form', [
				                    'model' => $messageModel,
				                    'url'   => '/jobseeker/js-message/create',
				                    'id'    => 'request_recommandation'
				                ]);  
				        Modal::end(); 
				    } ?> 
				</td>
			</tr>
		</tbody>
		</table>
</div>
</div>