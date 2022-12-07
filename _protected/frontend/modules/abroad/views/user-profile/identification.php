<div class='well profil'>
	<div class="row">
		<div class="col-sm-6">
			<div class="pull-left">
				<b><i class="glyphicon glyphicon-user"></i> Identification</b>
			</div><br>
			<hr>
		</div>
		<div class="col-sm-6">
			<div class="pull-right">
				<?php if (Yii::$app->user->can('mediator')) { ?>
					<?php if (isset($_GET['idOtherProfile'])) { ?>
						<?php if ($jobseeker->userProfile->user->status == \common\models\User::STATUS_NOT_ACTIVE) { ?>
							<div class='pull-right'><?php include('activate.php') ?></div>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				<?php if (!Yii::$app->user->can('employer')) { ?>
					<?php if (!isset($_GET['idOtherProfile'])) { ?>
						<div class='pull-right'><?php include('terminate.php') ?></div>
					<?php } ?>
					<div class='pull-right'><?php include('settings.php') ?></div>
					<div class='pull-right'>
						<?php //include('editIdentification.php')
						?>
					</div>
				<?php } ?>
			</div><br>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<label>First Name:</label>
		</div>
		<div class="col-sm-3">
			<?= $jobseeker->userProfile->firstname; ?>
		</div>
		<div class="col-sm-3">
			<label>Last Name:</label>
		</div>
		<div class="col-sm-3">
			<?= $jobseeker->userProfile->lastname; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<label>Gender:</label>
		</div>
		<div class="col-sm-3">
			<?= ($jobseeker->userProfile->gender == \common\models\UserProfile::GENDER_FEMALE) ? 'Female' : 'Male'; ?>
		</div>
		<div class="col-sm-3">
			<label>Marital Status:</label>
		</div>
		<div class="col-sm-3">
			<?= (isset($jobseeker->userProfile->maritalStatus->status)) ? $jobseeker->userProfile->maritalStatus->status : '*' ?>
		</div>
	</div>
	<!-- <div class="row">
<div class="col-sm-6">
	<div class="row mgbt-xs-0">
		<label class="col-xs-5 control-label">Email:</label>
		<div class="col-xs-7 controls"> -->
	<?php //echo $jobseeker->email; 
	?>
	<!-- </div> -->
	<!-- col-sm-10 -->
	<!-- </div>
</div>
<div class="col-sm-6">
	<div class="row mgbt-xs-0">
		<label class="col-xs-5 control-label">Phone:</label>
		<div class="col-xs-7 controls"> -->
	<?php //echo $jobseeker->userProfile->phone_number 
	?>
	<!-- </div> -->
	<!-- col-sm-10 -->
	<!-- </div>
</div>
</div> -->
	<div class="row">
		<div class="col-sm-3">
			<label>Country:</label>
		</div>
		<div class="col-sm-3">
			<?= (isset($jobseeker->userProfile->nationality0->cc_description)) ? $jobseeker->userProfile->nationality0->cc_description : '-'; ?>
		</div>
		<div class="col-sm-3">
			<label>Birthday:</label>
		</div>
		<div class="col-sm-3">
			<?= date('M d,Y', strtotime($jobseeker->userProfile->dob)); ?>
		</div>
	</div>
</div>