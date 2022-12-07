<?php kak\widgets\fieldset\FieldSet::begin([
	'legend' => '<i class="glyphicon glyphicon-lock"></i> ' . Yii::t('frontend', 'Login Information'),
	'active' => true, // false - hide content, default true
	'speed'  => 0, // animation speed default value 300
	'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
	'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
]); ?>
<div class="well">
	<div class='row'>
		<div class="col-md-6">
			<?php
			$username = $form->field($model, 'username');
			$username->enableClientValidation = false;
			?>
			<?= $form->field($model, 'email')->label('Email (Your username)<span style="color: red"><super>*</super></span>') ?>
			<?= $form->field($model, 'required_email')->hiddenInput(['value' => 'no_required', 'id' => 'required_email'])->label(false) ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Enter Phone Number')])->label(Yii::t("frontend", "Phone Number")); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<?php //echo Yii::$app->label::helper($model, 'password') 
			?>
			<?php echo $form->field($model, 'password')->passwordInput(); ?>
		</div>

		<div class="col-md-6">
			<?php echo $form->field($model, 'repeat_password')->passwordInput()->label(Yii::t("frontend", "Repeat Password")) ?>
		</div>
	</div>
	<span style="font-size: 12px;font-style: italic">Password should contain at least 10 characters with at least one lower case character, one upper case character, 2 numeric/digit and one special character (!,@,..). </span>
</div>
<?php kak\widgets\fieldset\FieldSet::end(); ?>