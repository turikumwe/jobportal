<fieldset class="well">
	 <div class='input-text'>
             <div class="input-div">
			<?= $form->field($model, 'mediator_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\MdMediator::find()->orderBy('id')->asArray()->all(), 'id', 'madiator_name'),
                    [
                        'placeholder' => Yii::t('frontend', 'Choose Mediator')
                    ]
                )
                ?></div></div>
    <div class='input-text'>
		<div class="input-div">
			 
			<?php echo $form->field($signupForm, 'username')->label(Yii::t('frontend', 'Username') . ' <sup><span style="color:red">*</span></sup>'); ?>  
		</div></div>
        <div class='input-text'>
		<div class="input-div">
			<?= $form->field($signupForm, 'phone')->textInput(['maxlength' => 13, 'maxlength' => 10, 'placeholder' => Yii::t('frontend', 'Enter Phone Number')])->label(Yii::t('frontend', 'Phone Number') . ' <sup><span style="color:red">*</span></sup>'); ?> 
		</div>
		<div class="input-div">
			<?= $form->field($signupForm, 'email')->label(Yii::t('frontend', 'E-mail') . ' <sup><span style="color:red">*</span></sup>'); ?>
			<?= $form->field($signupForm, 'required_email')->hiddenInput(['value' => 'required', 'id' => 'required_email'])->label(false); ?>
		</div>
	</div>
	<div class="input-text">
		<div class="input-div">
			<?php //echo Yii::$app->label::helper($model, 'password') 
			?>
			<?php echo $form->field($signupForm, 'password')->passwordInput()->label(Yii::t('frontend', 'Password') . ' <sup><span style="color:red">*</span></sup>'); ?>  
		</div>
		<div class="input-div">
			<?php echo $form->field($signupForm, 'repeat_password')->passwordInput()->label(Yii::t('frontend', 'Repeat Password') . ' <sup><span style="color:red">*</span></sup>'); ?>   
		</div>
		 
	</div>
	<span style="font-size: 12px;font-style: italic">Password should contain at least 10 characters with at least one lower case character, one upper case character, 2 numeric/digit and one special character (!,@,..). </span>
</fieldset>