<?php 
use common\models\JsMessage;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<div class="pd-10">
	<div class="vd_info tr">
		<?php if(!isset($_GET['idOtherProfile'])) { 
			$messageModel = new JsMessage();
			Modal::begin([
				'options' => [
					'tabindex' => false // important for Select2 to work properly
				],
				'header' => 'Add Message',
				"class" => "vd_bg-green", 
				'toggleButton' => [
					'class' => 'btn vd_btn btn-xs vd_bg-red',
					'label' => 'Compose'
				],
				'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
					//Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
			]);	                   
				echo $this->render('/js-message/_form', [
						'model' => $messageModel,
						'url'   => '/jobseeker/js-message/create',
						'id'    => 'send_message'
					]);  
			Modal::end(); 
		} ?> 
	</div>         
	<h3 class="mgbt-xs-15 mgtp-10 font-semibold"><i class="fa fa-bolt mgr-10 profile-icon"></i> MESSAGES</h3> 
	<div class="responsive">       
		<table class='table table-bordered table-striped'>
				<tr>
				<th>From</th>
				<th>Subject</th>
				<th>Message</th>
				<th>Sent</th>
				<th>Action</th>
			</tr>
			<?php
				$messages = \common\models\JsMessage::find()->received()->all();			               
				foreach($messages as $message){
			?>
				<tr>
				<td><?= (isset($message->user_from->userProfile->fullName)) ? $message->user_from->userProfile->fullName: '-'?></td>
				<td><?= $message->subject?></td>
				<td><?= substr($message->body, 0,40).'...'?></td>
				<td><?= $message->created_at;?></td>
				<td align="center">
						<a href="#">
						<?php
							$messageModel = JsMessage::find()->where(['id' => $message->id])->one();
							Modal::begin([
									'header' => '<span  style="color:black" >View message</span>',
									"class" => "vd_bg-green", 
									'toggleButton' => [
										'class' => 'btn vd_btn btn-xs vd_bg-blue',
										'label' => '<i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>'
									],
									'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
											//Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
								]);
									echo $this->render('/js-message/view', [
											'model' => $messageModel,
											
										]);  
								Modal::end(); 
							?>
						
					</a>
					<?php if(!isset($_GET['idOtherProfile'])) { ?>            
					<a href="#" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $message->id?>", js-message","message")'>
						<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
					</a>
					<?php } ?>
				</td>
				</tr> 
			<?php  } ?>
		</table>
	</div>
</div>

