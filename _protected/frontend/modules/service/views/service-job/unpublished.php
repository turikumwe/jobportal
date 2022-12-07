<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<?php if (count($unpublished) != 0) { ?>
	<?php //$k=0; for($i=0;$i<COUNT($unpublished)/2;$i++) {
	?>
	<div class="row">
		<?php foreach ($unpublished as $key => $job) { ?>
			<?php if ($job->action_id == 1) continue; ?>
			<div class="col col-md-12">
				<div class="well jobtype">
					<div>
						<a href="<?= Yii::$app->link->frontendUrl('/service/service-job/view?id=' . $job->id) ?>">
							<h4 class="mgbt-xs-15 mgtp-10 font-semibold"><?= $key + 1 ?>. <u><?= $job->jobtitle; ?></u>
								<?php if (!Yii::$app->user->can('user') && !Yii::$app->user->isGuest) { ?>
									<span class="label label-danger" style="font-size: 0.5em">UnPublished</span>
								<?php } ?>
							</h4>
						</a>
					</div>
					<b>Employer:</b> <?= $job->employer ?>
					<!-- <b>Salary:</b>    <?= number_format($job->job_remuneration) ?> RWF<br> -->
					<b>Location:</b> <?= isset($job->districts->district) ? $job->districts->district : '-' ?>
					<b>Job Type: </b> <?= isset($job->jobType->job_type) ? $job->jobType->job_type : 'Not applicable'; ?>
					<b>Posted at:</b> <?= date('Y-m-d', strtotime($job->created_at)) ?>
					<b>Opportunity Type:</b> <?= isset($job->opportunity->name) ? $job->opportunity->name : '-'; ?><br>
					<?php if (Yii::$app->user->can('user')) { ?>
						<span class="pull-right">
							<?php
							Modal::begin([
								'header' => 'Share:' . $job->jobtitle,
								"class" => "vd_bg-red",
								'toggleButton' => [
									'class' => 'btn vd_btn btn-xs vd_bg-blue',
									'label' => '<i class="glyphicon glyphicon-share" aria-hidden="true"></i>'
								],
								'footer' => ''
							]);
							$request = \Yii::$app->request;
							echo $this->render('opportunity/_share', [
								'model' => new \common\models\ServiceJobSharing(),
								'job'   => $job,
								'opportunity' => $job->opportunity->id
							]);
							Modal::end();
							?>
						</span>
						<span class="pull-right">&nbsp;</span>
						<span class="pull-right">
							<?php if ($share->saved($job->id) == 0) { ?>
							<?php
								Modal::begin([
									'header' => 'Save:' . $job->jobtitle,
									"class" => "vd_sm-red",
									'toggleButton' => [
										'class' => 'btn vd_btn btn-xs vd_bg-green',
										'label' => '<i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i>'
									],
									//'footer'=> ''
								]);
								$request = \Yii::$app->request;
								echo $this->render('opportunity/_save', [
									'model' => new \common\models\ServiceJobSharing(),
									'job'   => $job,
									'opportunity' => $job->opportunity->id
								]);
								Modal::end();
							} else {
								echo "<span class='btn vd_btn btn-xs vd_bg-default'><i class='glyphicon glyphicon-floppy-saved'aria-hidden='true'></i></span>";
							}
							?>
						</span>
					<?php } ?>

					<?php if (Yii::$app->user->can('employer') || Yii::$app->user->can('mediator')) { ?>
						<span class="pull-right">&nbsp;</span>
						<span class="pull-right btn vd_btn btn-xs vd_bg-blue">
							<a href="<?= Yii::$app->link->frontendUrl('/service/service-job/update-opportunity?id=' . $job->id) ?>">
								<i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
							</a>
						</span>
					<?php } ?>
					<div>
						<?php if (Yii::$app->user->can('user')) { ?>
							<?php if ($apply->applied($job->id) == 0) { ?>
						<?php
								Modal::begin([
									'header' => 'Apply Now:' . $job->jobtitle,
									"class" => "vd_bg-red",
									'toggleButton' => [
										'class' => 'btn vd_btn btn-xs vd_bg-green',
										'label' => 'Apply Now <i class="glyphicon glyphicon-apply" aria-hidden="true"></i>'
									],
									'footer' => ''
								]);
								$request = \Yii::$app->request;
								echo $this->render('opportunity/_apply', [
									'model'   	  => $apply,
									'job'     	  => $job,
									'summary' 	  => $summary,
									'opportunity' => $job->opportunity->id
								]);
								Modal::end();
							} else {
								echo "<span class='label label-default'>Applied </span>";
							}
						}
						?>
					</div>
				</div>
			</div>
			<?php } ?>
			<div>
			</div>
			</div>

		<?php } else { ?>
			<div class='row well jobtype'>
				<center><code>No Found ...</code></center>
			</div>
		<?php } ?>