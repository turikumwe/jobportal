<p>
<div class='well'><h1>Close your JobPortal Account</h1></div>

<hr>
<div class="well">
	<b>You can close JobPortal account at any time.</b> <br>
	Before doing so, please review the following info to understand what this action means for your account and your data.
	</p>

	<p>No one will have contact you for a job.</p>

	<p>
	If you're deactivating your account, make sure that you still have access to the email address or phone number that you use to log in to JobPortal. That way, you can easily reactivate your account by logging back in.
	</p>

	<hr>

	<code>Last chance !</code>
	<a href="#" onClick="terminate()" class="btn vd_btn btn-xs vd_bg-red">
	  Deactivate <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
	</a>
</div>

<script>
  function terminate() {
  	let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";  	
    if(confirm("Last Chance! Are you sure?.")){
        $.ajax({
            type: "POST",
            url: FRONTEND_BASE_URL+"/jobseeker/user-profile/terminate",
            dataType: "json",
            success: function(data){ 
                alert("your account has been deleted. Bye")
            }
        });
    }
   }
</script>