
<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html; 
?>
<?php if(count($saved) != 0) { ?>
<?php foreach($saved as $key=>$get) { ?>
<?php if(!isset($get->job->id)) continue;?>
	<div class='well jobtype'>
		<div class="row">
			<div class="col-sm-12">
				
				<div>
				<b>
					<a href="service-job/view?id=<?= $get->job->id?>">
					<?= $key+1?>. <?= $get->job->jobtitle;?>
					</a>
				</b>
				</div>
				<div><b>Posted by:</b> <?= $get->job->employer?></div>
				<div><b>Salary:</b> <?= number_format($get->job->job_remuneration)?>frw</div>
				<div><b>Type:</b> <?= !empty($get->job->jobType->job_type) ? $get->job->jobType->job_type: '' ?></div>
				<div><b>Location:</b> <?= isset($get->job->districts->district) ? $get->job->districts->district : '-'?></div>
				<div><b>Posted at:</b> <?= $get->job->created_at ?></div>
				<div><b>DeadLine:</b> <?= $get->job->closure_date;?></div>
			</div>
		</div>
	</div>
<?php } ?>
<?php } else { ?>
	<div class='row well jobtype'>
		<center><code>No Found ...</code></center>
	</div>
<?php } ?>
