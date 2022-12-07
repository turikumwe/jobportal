<?php foreach($jobs as $key=>$job) { ?>
	<div class='row well'>

		<div class="col-sm-12">
			<a href="#">
				<h3 class="mgbt-xs-15 mgtp-10 font-semibold"><?= $key+1?>. <u><?= $job->jobtitle;?></u></h3>
				<div><b>Poseted by:</b> <?= $job->employer?></div>
				<div><b>Salary:</b> <?= number_format($job->job_remuneration)?>frw</div>
				<div><b>Location:</b> <?= isset($job->district->district) ? $job->district->district : '-'?></div>
				<div>
					<?= $job->job_summary;?>...
				</div>
				<div><span class="label label-success">Apply Now</span></div>
			</a>
		</div>

	</div>
<?php } ?>
