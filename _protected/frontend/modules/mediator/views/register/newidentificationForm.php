    <?php 
    use trntv\filekit\widget\Upload;
    use Common\models\UserProfile;

    ?>

    
          
        <div class='input-text'> 
             <div class="input-div">
                <?= $form->field($mediator, 'firstname')->textInput(['maxlength' => true, 'placeholder' => 'First Name']) ?>
            </div>

            <div class="input-div">
                <?= $form->field($mediator, 'middlename')->textInput(['maxlength' => true, 'placeholder' => 'Middle Name']) ?>
            </div>
             <div class="input-div">
                <?= $form->field($mediator, 'lastname')->textInput(['maxlength' => true, 'placeholder' => 'Last Name']) ?>
            </div>

        </div>
 <div class='input-text'> 
 
        <div class='input-div'> 
             
               <?= $form->field($mediator, 'gender')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\SGender::find()->orderBy('gender')->asArray()->all(), 'id', 'gender'),
                    [
                        'placeholder' => Yii::t('frontend', 'Choose S ownership')
                    ]
                )
                ?>
            </div>
      
            <div class="input-div">
                <?= $form->field($mediator, 'position_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\SMediatorPosition::find()->orderBy('position')->asArray()->all(), 'id', 'position'),
                    [
                        'placeholder' => Yii::t('frontend', 'Choose Position')
                    ]
                )
                ?>
            </div></div>
 <div class='input-text'> 
        
          
        <div class='input-div'> 
            
            
                <?= $form->field($mediator, 'start_date')->dateInput(['maxlength' => true,'placeholder' => 'Employement Start date']) ?>
            </div>
     <div class='input-div'> 
            
            
                <?= $form->field($mediator, 'end_date')->dateInput(['maxlength' => true,'placeholder' => 'Employement end date']) ?>
            </div>

            
        </div>

 




