 <?php

    use trntv\filekit\widget\Upload;
    use Common\models\UserProfile;
    use yii\helpers\ArrayHelper;
    use kartik\select2\Select2;
    use yii\helpers\Url;

    ?>

 <fieldset>
     

     <div class='input-text'>
         <div class="input-div">
             <?= $form->field($employer, 'employer_type_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\SEmployerType::find()->orderBy('type')->asArray()->all(), 'id', 'type'),
                    [
                        'prompt' => Yii::t('frontend', 'Select Employer Type'),
                        'onchange' => '

                                // To get dropdownlist for courses

                                   var id = document.getElementById("emplemployer-employer_type_id").value;
                                   if(id == 1){
                                    $("#nationalnumber" ).show();
                                    $("#tin" ).hide();
                                    $("#regnumber" ).hide();
                                   }
                                   else if(id == 3){                                    
                                    $("#nationalnumber" ).hide();  
                                    $("#tin" ).show();                                 
                                    $("#regnumber" ).hide();
                                   }
                                    else{
                                    $("#nationalnumber" ).hide();
                                    $("#tin" ).hide();                                    
                                    $("#regnumber" ).show();
                                   } 
                                    
                                    $.post("' . Url::to(['../emplemployer/lists', 'id' => '']) . '"+$(this).val(),function(data){
                                         $("select#" ).html(data);
                                    });'
                    ]
                );
                ?>
         </div>
         <div class="input-div">
             <?= $form->field($employer, 'company_name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Enter Employer Name')])->label(Yii::t('frontend', 'Employer Name') . ' <sup><span style="color:red">*</span></sup>'); ?> 
         </div></div>
     <div class='input-text'>
         <div class="input-div">
             <?= $form->field($employer, 'company_name_abbraviatio')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Enter Employer Abbreviation')]); ?>
         </div>
    

     
         <div class="input-div">
             
                 <?= $form->field($employer, 'tin')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Enter TIN')]) ?>
          
             </div></div>
     <div class='input-text'>
             <div class="input-div">
                 <?= $form->field($employer, 'reg_number')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Enter Registration Number')]); ?>
             </div>

             <div class="input-div">
                 <?= $form->field($employer, 'national_id')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Enter National ID Number')]); ?>
             </div>
         </div>
     <div class="input-text">
         <div class="input-div">
             <?= $form->field($employer, 'registration_authority_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\SRegistrationauthority::find()->orderBy('registrationauthority')->asArray()->all(), 'id', 'registrationauthority'),
                    [
                        'placeholder' => Yii::t('frontend', 'Select Registration Authority')
                    ]
                )
                ?>
         </div>
         </div>
          
     
     <div class='input__fld'>
         <div class="input__fld">
             <?php /*echo$form->field($employer, 'ownership_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\SOwnership::find()->orderBy('ownership')->asArray()->all(), 'id', 'ownership'),
        'options' => ['placeholder' => Yii::t('app', 'Choose S ownership')],
        'pluginOptions' => [
        'allowClear' => true
        ],
        ]); */ ?>
         </div>
         <div class="input__fld">
             <?php /*echo $form->field($employer, 'opening_date')->widget(\kartik\datecontrol\DateControl::classname(), [
            'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
            'saveFormat' => 'php:Y-m-d',
            'ajaxConversion' => false,
            'options' => [
                'pluginOptions' => [
                    'placeholder' => Yii::t('app', 'Choose Opening Date'),
                    'autoclose' => true
                ]
            ],
        ]); */ ?>
         </div>
     </div>
 </fieldset>