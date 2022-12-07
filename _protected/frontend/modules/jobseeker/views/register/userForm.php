<fieldset class="well">
	 
	<?php
		$username = $form->field($model, 'username');
		$username->enableClientValidation = false;
	?>
	<div class="inline__flds">
		<div class="input__fld">
			<?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('frontend', 'Enter Email Here')])->label('Email (Your username)<span style="color:#FF0000"><super>*</super></span>'); ?>
			<?= $form->field($model, 'required_email')->hiddenInput(['value' => 'no_required', 'id' => 'required_email'])->label(false) ?>
		</div>
            <br />
		<div class="input__fld">
			<?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Enter Phone Number Here')])->label(Yii::t('frontend', 'Phone Number') . ' <sup><span style="color:red">*</span></sup>'); ?> 
		</div>
	</div>
	<div class="input-text">
		<div class="input-div">
			<?php //echo Yii::$app->label::helper($model, 'password') 
			?>
			<?php echo $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('frontend', 'Enter Password Here')])->label(Yii::t('frontend', 'Password') . ' <sup><span style="color:red">*</span></sup>'); ?>  
		</div>
		<div class="input-div">
			<?php echo $form->field($model, 'repeat_password')->passwordInput(['placeholder' => Yii::t('frontend', 'Confirm Password Here')])->label(Yii::t('frontend', 'Repeat Password') . ' <sup><span style="color:red">*</span></sup>'); ?> 
		</div>
	</div>
	<span class="tip">
		Password should contain at least 10 characters with at least one lower case character, one upper case character, 2 numeric/digit and one special character (!,@,..).
	</span>
</fieldset>