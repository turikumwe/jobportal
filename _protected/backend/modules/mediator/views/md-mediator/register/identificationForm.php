    <?php 
    use trntv\filekit\widget\Upload;
    use Common\models\UserProfile;

    ?>

    <?php kak\widgets\fieldset\FieldSet::begin([
            'legend' => Yii::t('app-dash','<i class="glyphicon glyphicon-book"></i> Mediator institution info'),
            'active' => true, // false - hide content, default true
            'speed'  => 0, // animation speed default value 300
            'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
            'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
        ]);?>
          
        <div class='row'> 
             <div class="col-md-6">
                <?= $form->field($mediator, 'madiator_name')->textInput(['maxlength' => true, 'placeholder' => 'Mediator institution Name']) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($mediator, 'registration_number')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
            </div>

        </div>

        <div class='row'> 
            <div class="col-md-6">
                <?= $form->field($mediator, 'ownership_id')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\SOwnership::find()->orderBy('ownership')->asArray()->all(), 'id', 'ownership'),
                'options' => ['placeholder' => Yii::t('app', 'Choose S ownership')],
                'pluginOptions' => [
                'allowClear' => true
                ],
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($mediator, 'mediator_type_id')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SMediatorType::find()->orderBy('mediator_type')->asArray()->all(), 'id', 'mediator_type'),
                'options' => ['placeholder' => Yii::t('app', 'Choose mediator type')],
                'pluginOptions' => [
                'allowClear' => true
                ],
                ]); ?>
            </div>
        </div>
          
        <div class='row'> 
            
            <div class="col-md-6">
                <?= $form->field($mediator, 'opening_date')->widget(\kartik\datecontrol\DateControl::class, [
                    'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                    'saveFormat' => 'php:Y-m-d',
                    'ajaxConversion' => false,
                    'options' => [
                        'pluginOptions' => [
                            'placeholder' => Yii::t('app', 'Choose Opening Date'),
                            'autoclose' => true
                        ]
                    ],
                ]); ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($mediator, 'registration_authority_id')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\SRegistrationauthority::find()->orderBy('registrationauthority')->asArray()->all(), 'id', 'registrationauthority'),
                'options' => ['placeholder' => Yii::t('app', 'Choose S registrationauthority')],
                'pluginOptions' => [
                'allowClear' => true
                ],
                ]); ?>
            </div>
        </div>

<?php kak\widgets\fieldset\FieldSet::end(); ?>




