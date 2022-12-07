
<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html; 
?>
<?php if(count($saved) != 0) { ?>
<?php foreach($saved as $key=>$get) { ?>
<?php if(!isset($get->event->id)) continue;?>
	<div class='well jobtype'>
		<div class="row">
			<div class="col-sm-12">
				<div>
					<b>
					<a href="/service/service-event/view?id=<?= $get->event->id?>">
					<h3 class="mgbt-xs-15 mgtp-10 font-semibold"><?= $key+1?>. <u><?= $get->event->event_title?></u></h3>
					</a>
					</b>

				</div>
				<div><b>Event Start Date:</b> <?= $get->event->start_date?></div>
				<div><b>Event End Date:</b> <?= $get->event->end_date?></div>
				<div><b>Location:</b> <?= $get->event->location->sector?></div>
				<div><b>Venue:</b> <?= $get->event->venue?></div>
				<div><b>Number of participants:</b> <?= $get->event->number_participant?></div>
				

			</div>
		</div>
	</div>
<?php } ?>
<?php } else { ?>
	<div class='row well jobtype'>
		<center><code>No Found ...</code></center>
	</div>
<?php } ?>
