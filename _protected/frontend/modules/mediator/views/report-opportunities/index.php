<div class="container pd-20" id="job" style="height: 100%;">
	
	<div class="col-lg-12">		
		<div class="col-xl-3 col-lg-5 col-md-5 col-xs-5 jobtype" style="margin-left: 10px;margin-bottom: 50px;">
			<a href="<?= Yii::$app->link->frontendUrl('/mediator/report-service/job?archive=false')?>">
				<h4 class="mgbt-xs-15 mgtp-10 font-semibold"><u>Jobs</u></h4>
			</a>
		</div>
		
		<div class="col-xl-5 col-lg-5 col-md-5 col-xs-5 jobtype" style="margin-left: 10px;margin-bottom: 50px;">
			<a href="<?= Yii::$app->link->frontendUrl('/mediator/report-service/event?archive=false')?>">
				<h4 class="mgbt-xs-15 mgtp-10 font-semibold"><u>Events</u></h4>
			</a>
		</div>

		<div class="col-xl-5 col-lg-5 col-md-5 col-xs-5 jobtype" style="margin-left: 10px;margin-bottom: 50px;">
			<a href="<?= Yii::$app->link->frontendUrl('/mediator/report-service/archive-job?archive=true')?>">
				<h4 class="mgbt-xs-15 mgtp-10 font-semibold"><u>Archive (Jobs) </u></h4>
			</a>
		</div>

		<div class="col-xl-5 col-lg-5 col-md-5 col-xs-5 jobtype" style="margin-left: 10px;margin-bottom: 50px;">
			<a href="<?= Yii::$app->link->frontendUrl('/mediator/report-service/archive-event?archive=true')?>">
				<h4 class="mgbt-xs-15 mgtp-10 font-semibold"><u>Archive (Events)</u></h4>
			</a>
		</div>
	</div>

</div>
