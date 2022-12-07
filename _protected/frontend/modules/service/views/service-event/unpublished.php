<?php 
use \yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\Html; 
?>
<?php if(count($opportunities) != 0) { ?>
<?php foreach($opportunities as $key=>$get) { ?>
	<?php if($get->action_id == 1) continue;?>
	<div class='row'>
		<div class="col col-md-12 well jobtype">
				<div>
				<a href="<?= Yii::$app->link->frontendUrl('/service/service-event/view?id='.$get->id)?>">
					<h4 class="mgbt-xs-15 mgtp-10 font-semibold"><?= $key+1?>. <u><?= $get->event_title?></u>
						<?php if(!Yii::$app->user->can('user')  && !Yii::$app->user->isGuest ) { ?>
							<span class="label label-danger" style="font-size: 0.5em">UnPublished</span>
						<?php } ?>
					</h4>
				</a>
				<?php if(Yii::$app->user->can('user')) { ?>
						<span class="pull-right">
							<?php 
								Modal::begin([
									'header' => 'Share:'.$get->event_title,
									"class" => "vd_bg-red", 
									'toggleButton' => [
									'class' => 'btn vd_btn btn-xs vd_bg-blue',
									'label' => '<i class="glyphicon glyphicon-share" aria-hidden="true"></i>'
								],
									'footer'=> ''
								]);
									$request = \Yii::$app->request;
									echo $this->render('opportunity/_share', [
									'model' => new \common\models\ServiceEventSharing(),
									'get'   => $get,
									'opportunity' => $get->opportunity->id
								]);  
								Modal::end();
							?>
						</span>
						<span class="pull-right">&nbsp;</span>
						<span class="pull-right">
							<?php if($share->saved($get->id) == 0) { ?>
							<?php 
								Modal::begin([
									'header' => 'Save:'.$get->event_title,
									"class" => "vd_sm-red", 
									'toggleButton' => [
									'class' => 'btn vd_btn btn-xs vd_bg-green',
									'label' => '<i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i>'
								],
									//'footer'=> ''
								]);
									$request = \Yii::$app->request;
									echo $this->render('opportunity/_save', [
									'model' => new \common\models\ServiceEventSharing(),
									'get'   => $get,
									'opportunity' => $get->opportunity->id
								]);  
								Modal::end();
							}else{
								echo "<span class='btn vd_btn btn-xs vd_bg-default'><i class='glyphicon glyphicon-floppy-saved'aria-hidden='true'></i></span>";
							}
							?>
						</span>
					<?php } else { ?>
						<span class="pull-right">&nbsp;</span>
						<span class="pull-right btn vd_btn btn-xs vd_bg-blue">
							<a href="<?= Yii::$app->link->frontendUrl('/service/service-event/update-opportunity?id='.$get->id)?>">
								<i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
							</a>
						</span>
					<?php } ?>
				</div>
				<div><b>Event Start Date:</b> <?= $get->start_date?></div>
				<div><b>Event End Date:</b> <?= $get->end_date?></div>
				<div><b>Location:</b> <?= $get->location->sector?></div>
				<div><b>Venue:</b> <?= $get->venue?></div>
				<div><b>Number of participants:</b> <?= $get->number_participant?></div>
				<div><b>Opportunity Type:</b><?= isset($get->opportunity->name) ? $get->opportunity->name : '-';?></div>	
				
				
			<div>
				<?php if(Yii::$app->user->can('user')) { ?>
					<?php if($apply->eventApplied($get->id) == 0) { ?> 
					<?php 
						Modal::begin([
							'header' => 'Apply Now:'.$get->event_title,
							"class" => "vd_bg-red", 
							'toggleButton' => [
							'class' => 'btn vd_btn btn-xs vd_bg-green',
							'label' => 'Apply Now <i class="glyphicon glyphicon-apply" aria-hidden="true"></i>'
						],
							'footer'=> ''
						]);
							$request = \Yii::$app->request;
							echo $this->render('opportunity/_apply', [
								'model'       => $apply,
								'get'       => $get,
								'opportunity' => $get->opportunity->id
						]);  
						Modal::end();
					}else {
						echo "<span class='label label-default'>Applied </span>";
					}
				}
				?>
			</div>
			
		</div>

	</div>
<?php } ?>

	<div>
	<?php echo LinkPager::widget([
	    	'pagination'=>$pagination,
		]); 
	?>
	</div>

<?php } else { ?>
	<div class='row well jobtype'>
		<center><code>No Found ...</code></center>
	</div>
<?php } ?>
