 
		<fieldset class="well" >
<div class='input-text'> 
	<div class="input-div">
		<?php echo $form->field($model, 'username')->label(Yii::t('frontend', 'Username') . ' <sup><span style="color:red">*</span></sup>'); ?>  
	</div>
    </div>
<div class='input-text'> 
	<div class="input-div">
		<?=  $form->field($model, 'phone') ?>  
	</div>

	<div class="input-div">
		<?= $form->field($model, 'email')->label('E-mail <sup><span style="color:red">*</span></sup>') ?> 
		<?= $form->field($model, 'required_email')->hiddenInput(['value' => 'required','id' => 'required_email'])->label(false) ?>
	</div>
</div>

<div class='input-text'> 
	<div class="input-div">
		<?php echo $form->field($model, 'password')->passwordInput()->label(Yii::t('frontend', 'Password') . ' <sup><span style="color:red">*</span></sup>'); ?>  
	</div>

	<div class="input-div">
		<?php echo $form->field($model, 'repeat_password')->passwordInput()->label(Yii::t('frontend', 'Repeat Password') . ' <sup><span style="color:red">*</span></sup>'); ?>  
	</div>

</div> 

                </fieldset>