
<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html; 
?>
<?php if(count($applied) != 0) { ?>
<?php foreach($applied as $key=>$get) { ?>
<?php if(!isset($get->job->id)) continue;?>
	<div class='well jobtype'>
		<div class="row">
			<div class="col-sm-12">
				<div>
					<a href="<?= Yii::$app->link->frontendUrl('/service/service-job/view?id='.$get->job->id) ?> ">
						<h3 class="mgbt-xs-15 mgtp-10 font-semibold"><?= $key+1?>. <u><?= $get->job->jobtitle;?></u></h3>
					</a>
					<?php if(Yii::$app->user->can('user')) { ?>
						<span class="pull-right">
							<?php /*
							Modal::begin([
								'header' => 'Share:'.$get->job->jobtitle,
								"class" => "vd_bg-red", 
								'toggleButton' => [
								'class' => 'btn vd_btn btn-xs vd_bg-blue',
								'label' => 'Share <i class="glyphicon glyphicon-share" aria-hidden="true"></i>'
							],
								'footer'=> ''
							]);
								$request = \Yii::$app->request;
								echo $this->render('job/_share', [
								'model' => new \common\models\ServiceJobSharing(),
								'job'   => $get->job
							]);  
							Modal::end();
							*/
						?>
						</span>
					<?php } ?>
				</div>
				<div><b>Posted by:</b> <?= $get->job->employer?></div>
				<div><b>Type:</b> <?= !empty($get->job->jobType->job_type) ? $get->job->jobType->job_type: '' ?></div>
				<div><b>Posted at:</b> <?= $get->job->created_at ?></div>
				<div><b>Location:</b> <?= isset($get->job->districts->district) ? $get->job->districts->district : '-'?><br></div>
			</div>
		</div>
	</div>
<?php } ?>
<?php } else { ?>
	<div class='row well jobtype'>
		<center><code>No Found ...</code></center>
	</div>
<?php } ?>
