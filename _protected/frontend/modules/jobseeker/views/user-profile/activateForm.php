

	<div class='well'><h1>Activate this account</h1>
	Firstname : <?= $model->firstname;?><br>
	Lastname : <?= $model->lastname;?>
	Phone Number: <?= $model->phone_number;?>
	</div>

<div class="container">
	<div class="row">
		<a href="#" onClick="activate(<?= $model->user_id?>)" class="btn vd_btn btn-xs vd_bg-red">
			Click here to activate the account <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
		</a>
		</div>

</div>

<script>
	function activate(id) {
		let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";  	
	
		$.ajax({
				type: "POST",
				url: FRONTEND_BASE_URL+"/jobseeker/user-profile/activate?id="+id,
				dataType: "json",
				success: function(data){ 
					location.reload();
				}
		});

	 }
</script>