<?php

use Common\models\UserProfile;
use yii\helpers\Url;
use yii\jui\DatePicker;
?>
 <div class="input-text">
            <div class="input-div">
                <?php //echo Yii::$app->label::helper($identification,'document_type')
                ?>
                <?= $form->field($identification, 'document_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SDocumenttype::find()->orderBy('id')->asArray()->all(), 'id', 'documenttype'),
                    [
                        'id' => 'userprofile-document_id',
                        'prompt' => Yii::t('frontend', 'Select Document Type'),
                        'onchange' => '
                            // To get dropdownlist

                            var id = document.getElementById("userprofile-document_id").value;
                            if(id == 1){
                                $("#nid" ).show();
                                $("#passport" ).hide();
                                $("#identification" ).hide();
                                $("#go" ).show();
                                $("#passportinfo" ).hide();
                            }
                            else if(id == 2){
                                $("#passport" ).show();
                                $("#nid" ).hide();
                                $("#identification" ).hide();
                                $("#go" ).hide();
                                $("#passportinfo" ).show();
                            }
                                else{
                                $("#nid" ).hide();
                                $("#passport" ).hide();
                                $("#identification" ).hide();
                                $("#go" ).hide();
                                $("#passportinfo" ).hide();
                            }
                                
                            $.post("' . Url::to(['../commonperson/lists', 'id' => '']) . '"+$(this).val(),function(data){
                                $("select#" ).html(data);
                            });
                        '
                    ]
                )->label(Yii::t('frontend', 'Document type') . ' <sup><span style="color:red">*</span></sup>') ?>   
            </div></div>
     <div id='passport' style='display:none'>
         <div class='input-text' > 
             <div class="input-div">
                <?= $form->field($identification, 'passport_number')->textInput(['maxlength' => true, 'placeholder' => 'Passport Number']) ?>
            </div>
         </div>
<div class='input-text' > 
             <div class="input-div">
                <?= $form->field($identification, 'pfirst_name')->textInput(['maxlength' => true, 'placeholder' => 'First Name']) ?>
            </div>

            <div class="input-div">
                <?= $form->field($identification, 'pmiddle_name')->textInput(['maxlength' => true, 'placeholder' => 'Middle Name']) ?>
            </div>
             <div class="input-div">
                <?= $form->field($identification, 'plast_name')->textInput(['maxlength' => true, 'placeholder' => 'Last Name']) ?>
            </div>

        </div>
 <div class='input-text'> 
 
        <div class='input-div'> 
             
               <?= $form->field($identification, 'pgender_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\SGender::find()->orderBy('gender')->asArray()->all(), 'id', 'gender'),
                    [
                        'placeholder' => Yii::t('frontend', 'Choose S ownership')
                    ]
                )
                ?>
            </div>
      <div class='input-div'> 
             
               <?= $form->field($identification, 'country_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('cc_description')->asArray()->all(), 'id', 'cc_description'),
                    [
                        'placeholder' => Yii::t('frontend', 'Choose S ownership')
                    ]
                )
                ?>
            </div>
     </div>
      
             </div>
 <div id='nid' style='display:none'>
     <div class='input-text' > 
             <div class="input-div">
                <?= $form->field($identification, 'id_number')->textInput(['maxlength' => true, 'placeholder' => 'ID Number']) ?>
            </div>
         </div>
<div class='input-text' > 
             <div class="input-div">
                <?= $form->field($identification, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'First Name']) ?>
            </div>

            <div class="input-div">
                <?= $form->field($identification, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => 'Middle Name']) ?>
            </div>
             <div class="input-div">
                <?= $form->field($identification, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Last Name']) ?>
            </div>

        </div>
 <div class='input-text'> 
 
        <div class='input-div'> 
             
               <?= $form->field($identification, 'gender_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\SGender::find()->orderBy('gender')->asArray()->all(), 'id', 'gender'),
                    [
                        'placeholder' => Yii::t('frontend', 'Choose S ownership')
                    ]
                )
                ?>
            </div>
      
     </div>
      
             </div>
<div class='input-text'> 
    <div class="input-div">
<?= $form->field($mediator, 'madiator_name')->textInput(['maxlength' => true, 'placeholder' => 'Mediator Name']) ?>
    </div>

    <div class="input-div">
        <?= $form->field($mediator, 'registration_number')->textInput(['maxlength' => true, 'placeholder' => 'Company Name Abbraviation']) ?>
    </div>

</div>

<div class='input-text'> 
    <div class="input-div">

<?=
$form->field($mediator, 'ownership_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(common\models\SOwnership::find()->orderBy('ownership')->asArray()->all(), 'id', 'ownership'),
        [
            'placeholder' => Yii::t('frontend', 'Choose S ownership')
        ]
)
?>
    </div>
    <div class="input-div">

<?=
$form->field($mediator, 'mediator_type_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(backend\models\SMediatorType::find()->orderBy('mediator_type')->asArray()->all(), 'id', 'mediator_type'),
        [
            'placeholder' => Yii::t('frontend', 'Choose mediator type')
        ]
)
?>
    </div>
</div>

<div class='input-text'> 

    <div class="input-div">
        <?= $form->field($mediator, 'opening_date')->dateInput(['maxlength' => true]) ?>

    </div>

    <div class="input-div">

<?=
$form->field($mediator, 'registration_authority_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\SRegistrationauthority::find()->orderBy('registrationauthority')->asArray()->all(), 'id', 'registrationauthority'),
        [
            'placeholder' => Yii::t('frontend', 'Choose S registrationauthority')
        ]
)
?>
    </div>
</div> 




