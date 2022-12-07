<div class='row'> 
	<div class="col-md-4">
		<?php echo $form->field($signupForm, 'username') ?>  
	</div>
	<div class="col-md-4">
		<?php echo $form->field($signupForm, 'password')->passwordInput(); ?> 
	</div>

	<div class="col-md-4">
		<?php echo $form->field($signupForm, 'repeat_password')->passwordInput() ?> 
	</div>

</div>