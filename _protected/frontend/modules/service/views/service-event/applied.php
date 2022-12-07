
<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html; 
?>
<?php if(count($applied) != 0) { ?>
<?php foreach($applied as $key=>$get) { ?>
<?php if(!isset($get->even->id)) continue;?>
	<div class='row well jobtype'>
		<div class="col-sm-12">
				<div>
					<a href="<?= Yii::$app->link->frontendUrl('/service/service-event/view?id='.$get->even->id)?>">
					<h3 class="mgbt-xs-15 mgtp-10 font-semibold"><?= $key+1?>. <u><?= $get->even->event_title ?></u></h3>
					</a>
					
				</div>
				<div><b>Start date:</b> <?= $get->even->start_date?></div>
				<div><b>Event Start Date:</b> <?= $get->even->start_date?></div>
				<div><b>Event End Date:</b> <?= $get->even->end_date?></div>
				<div><b>Location:</b> <?= $get->even->location->sector?></div>
				<div><b>Venue:</b> <?= $get->even->venue?></div>
				<div><b>Number of participants:</b> <?= $get->even->number_participant?></div>				
			<div>
				<?php 
					if(Yii::$app->user->can('user')) { 
						// if($apply->applied($get->even->id) != 0) { 
						// 	echo "<span class='label label-default'>Applied </span>";
						// }
					}
				?>
			</div>
		</div>
	</div>
<?php } ?>
<?php } else { ?>
	<div class='row well jobtype'>
		<center><code>No Found ...</code></center>
	</div>
<?php } ?>
