
<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html; 
?>
<?php if(count($shared) != 0) { ?>
<?php foreach($shared as $key=>$opportunity) { ?>
<?php if(!isset($opportunity->job->id)) continue;?>
	<div class='well jobtype'>
		<div class="row">
			<div class="col-sm-12">
				<div>
					<b>
						<a href="service-job/view?id=<?= $opportunity->job->id?>">
						<?= $key+1?>. <?= $opportunity->job->jobtitle;?>
						</a>
					</b>
				</div>
				<div><b>Shared to:</b> <?= $opportunity->jobSeeker->fullName?></div>
				<div>
					<b>Message:</b> <?= $opportunity->message?>
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