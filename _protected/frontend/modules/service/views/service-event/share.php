
<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html; 
?>
<?php if(count($shared) != 0) { ?>
<?php foreach($shared as $key=>$get) { ?>
	<?php if(!isset($get->event->id)) continue;?>
		<div class='well jobtype'>
		<div class="row">
			<div class="col-sm-12">
				<div>
				<b>
					<a href="service-event/view?id=<?= $get->event->id?>">
						Event: <?= $key+1?>. <?= $get->event->event_title ?>
					</a>
				</b>
				</div>
				<div><b>Shared to:</b> <?= $get->jobSeeker->fullName?></div>
				<div>
					Message: <?= $get->message?>
				</div>			
			</div>
		</div>
	</div>
<?php } ?>
<?php } else { ?>
	<div class='row well jobtype'>
		<center><code>No Found ...</code></center>
	</div>
<?php } ?>
