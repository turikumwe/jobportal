<div class='well profil'>
	<div class="row">
		<div class="col-sm-6">
			<div class="pull-left">
				<b><i class="glyphicon glyphicon-home"></i> Identification</b>
			</div><br>
			<hr style="background-color: white">
		</div>
		<div class="col-sm-6">
			<div class="pull-right">
				<?php if (!isset($_GET['idOtherProfile'])) { ?>
					<div class='pull-right'><?php include('terminate.php') ?></div>
					<div class='pull-right'><?php include('settings.php') ?></div>
					<div class='pull-right'><?php include('editIdentification.php') ?></div>
				<?php } ?><br>
				<hr style="background-color: white">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label>Company Name:</label>
		</div>
		<div class="col-sm-8">
			<?= $employer->employerProfile->company_name; ?>
			(<?= $employer->employerProfile->company_name_abbraviatio; ?>)
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label>TIN:</label>
		</div>
		<div class="col-sm-8">
			<?= $employer->employerProfile->tin ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label>Opening Date:</label>
		</div>
		<div class="col-sm-8">
			<?= date('M d,Y', strtotime($employer->employerProfile->opening_date)); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label>Employer Type :</label>
		</div>
		<div class="col-sm-8">
			<?= (isset($employer->employerProfile->employerType->type)) ? $employer->employerProfile->employerType->type : '-'; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label>Email:</label>
		</div>
		<div class="col-sm-8" style="overflow: wrap">
			<?= $employer->email; ?>
		</div>
	</div>
</div>