<?php kak\widgets\fieldset\FieldSet::begin([
'legend' => Yii::t('app-dash','<i class="glyphicon glyphicon-lock"></i>Login Information'),
'active' => true, // false - hide content, default true
'speed'  => 0, // animation speed default value 300
'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
]);?>
<div class="well">
	<div class='row'> 
		<div class="col-md-4">
			<?php echo $form->field($model, 'username') ?>  
		</div>

		<div class="col-md-4">
			<?=  $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Phone number']) ?>
		</div>

		<div class="col-md-4">
			<?=  $form->field($model, 'email') ?> 
			<?= $form->field($model, 'required_email')->hiddenInput(['value' => 'no_required','id' => 'required_email'])->label(false) ?>
		</div>

	</div>

	<div class="row">
		<div class="col-md-4">
			<?= Yii::$app->label::helper($model,'password')?>
			<?php echo $form->field($model, 'password')->passwordInput()->label(false); ?> 
		</div>

		<div class="col-md-4">
			<?php echo $form->field($model, 'repeat_password')->passwordInput() ?> 
		</div>
	</div> 
</div>
<?php kak\widgets\fieldset\FieldSet::end(); ?>