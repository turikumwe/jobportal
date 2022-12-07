<div class="row">
    <div class="col col-md-4">
        <?= $form->field($person, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'First Name']) ?>
    </div>
    <div class="col col-md-4">
        <?= $form->field($person, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => 'Middle Name']) ?>
    </div>
    <div class="col col-md-4">
        <?= $form->field($person, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Last Name']) ?>
    </div>
</div>

<div class="row">
    <div class="col col-md-4">
        <?= $form->field($person, 'gender_id')->widget(\kartik\widgets\Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\SGender::find()->orderBy('gender')->asArray()->all(), 'id', 'gender'),
            'options' => ['placeholder' => Yii::t('app', 'Gender')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>

</div>

<div class="row">
    <div class="col col-md-6">
        <?= $form->field($signupForm, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Phone']) ?>
    </div>
    <div class="col col-md-6">
        <?= $form->field($signupForm, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email']) ?>
    </div>
</div>
