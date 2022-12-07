    <?php 
    use trntv\filekit\widget\Upload;
    use Common\models\UserProfile;
    use \yii\helpers\ArrayHelper;
    use \kartik\widgets\Select2;
    use yii\helpers\Url;
    ?>

    <?php kak\widgets\fieldset\FieldSet::begin([
            'legend' => Yii::t('app-dash','<i class="glyphicon glyphicon-book"></i> Mediator address'),
            'active' => true, // false - hide content, default true
            'speed'  => 0, // animation speed default value 300
            'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
            'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
        ]);?>
        
        <div class='row'> 
            <div class="col-md-4">
                <?= $form->field($address, 'province_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\backend\models\SProvince::find()->orderBy('province')->asArray()->all(), 'id', 'province'),
                'theme' => Select2::THEME_KRAJEE, 
                            'options'=>[
                                'placeholder'=>Yii::t('app', 'Choose Province'),
                                'onchange'=>'
                                $.post( "'.Url::to(['/s-district/lists', 'id' => '']).'"+$(this).val(),function(data){
                                 $("#mdaddress-district_id" ).html(data);
                                });'
                            ],
                            'language' => 'en',
                            'pluginOptions'=>['alloweClear'=>true],
                ]); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($address, 'district_id')->widget(Select2::class,[
                'data' => ArrayHelper::map(\backend\models\SDistrict::find()->where(['id' => 0])->orderBy('district')->asArray()->all(), 'id', 'district'),
                'theme' => Select2::THEME_KRAJEE, 
                'options'=>[
                    'placeholder'=>'Select a district',
                    'onchange'=>'
                        $.post( "'.Url::to(['/s-geo-sector/lists', 'id' => '']).'"+$(this).val(),function(data){
                        $("#mdaddress-geo_sector_id" ).html(data);
                    });'
                ],
                'language' => 'en',
                'pluginOptions'=>['alloweClear'=>true],
                ]);
                ?>  
            </div>
           
            <div class="col-md-4">
                <?= $form->field($address, 'geo_sector_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\backend\models\SGeosector::find()->where(['id' => 0])->orderBy('sector')->asArray()->all(), 'id', 'sector'),
                'options' => ['placeholder' => Yii::t('app', 'Choose Sector')],
                'pluginOptions' => [
                'allowClear' => true
                ],
                ]); ?>
            </div>
        </div>

        <div class='row'>
            <div class="col-md-6">
                 <?= $form->field($address, 'physical_address')->textArea(['maxlength' => true, 'placeholder' => 'Physical Address']) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($address, 'pobox')->textInput(['maxlength' => true, 'placeholder' => 'PoBox']) ?>
            </div>
        </div>


<?php kak\widgets\fieldset\FieldSet::end(); ?>




