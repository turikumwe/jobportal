<fieldset class="well"><div class="input-text">
    <div class="input-div">
        <?= $form->field($person, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'First Name']) ?>
    </div>
    <div class="input-div">
        <?= $form->field($person, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => 'Middle Name']) ?>
    </div>
    <div class="input-div">
        <?= $form->field($person, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Last Name']) ?>
    </div>
</div>

<div class="input-text">
    <div class="input-div">
        <?= $form->field($person, 'gender_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\SGender::find()->orderBy('id')->asArray()->all(), 'id', 'gender'),
                    [
                        'placeholder' => Yii::t('frontend', 'Choose Gender')
                    ]
                )
                ?>
    </div>
 <div class="input-div"> 
            <?= $form->field($model, 'position_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\SMediatorPosition::find()->orderBy('position')->asArray()->all(), 'id', 'position'),
                    [
                        'placeholder' => Yii::t('frontend', 'Choose Position')
                    ]
                )
                ?>
        </div>
</div>

 
<div class="input-text">
    <div class="input-div">  
             <?= $form->field($model, 'start_date')->dateInput(['maxlength' => true,'placeholder' => 'Employement Start date']) ?>
  
        </div>
        <div class="input-div">
            <?= $form->field($model, 'end_date')->dateInput(['maxlength' => true,'placeholder' => 'Employement end date']) ?>
  
        </div>
    </div>
</fieldset>