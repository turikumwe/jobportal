    <?php 
    use trntv\filekit\widget\Upload;
    use Common\models\UserProfile;
    use backend\models\SGeosector;
    use backend\models\SProvince;
    use backend\models\SDistrict;
    use \yii\helpers\ArrayHelper;
    use \kartik\widgets\Select2;
    use yii\helpers\Url;

    if(isset($model->province_id)) {

        $model->district_id = SDistrict::find()->where(['province_id' => $model->province_id])['district_id'];
        $model->sector_id   = SGeosector::find()->where(['district_id' => $model->district_id])['sector_id'];
        
    }
    

    ?>

    <?php kak\widgets\fieldset\FieldSet::begin([
            'legend' => Yii::t('app-dash','<i class="glyphicon glyphicon-book"></i> Identification'),
            'active' => true, // false - hide content, default true
            'speed'  => 0, // animation speed default value 300
            'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
            'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
        ]);?>
          
        <div class='row'> 
        
         <div class="col-md-4">
            <?= Yii::$app->label::helper($identification,'document_type')?>
            <?= $form->field($identification, 'document_type')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SDocumenttype::find()->orderBy('id')->asArray()->all(), 'id', 'documenttype'),
                'options' => [
                    'placeholder' => 'Document type',
                    'onchange'=>'

                                // To get dropdownlist

                                   var id = document.getElementById("userprofile-document_type").value;
                                   if(id == 1){
                                    $("#nid" ).show();
                                    $("#passport" ).hide();
                                   }
                                   else if(id == 2){
                                    $("#passport" ).show();
                                    $("#nid" ).hide();  
                                   }
                                    else{
                                    $("#nid" ).hide();
                                    $("#passport" ).hide();
                                   }
                                    
                                    $.post("'.Url::to(['../commonperson/lists', 'id'=> '']).'"+$(this).val(),function(data){
                                         $("select#" ).html(data);
                                    });' 
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false); ?>  
         </div>
         <div class="col-md-4" id='passport' style='display:none'>
             <?= $form->field($identification, 'passport_number')->textInput(['maxlength' => true, 'placeholder' => 'Passport number']) ?>
         </div>
         <div class="col-md-4" id='nid' style='display:none'>
             <?= $form->field($identification, 'id_number')->textInput(['maxlength' => true, 'placeholder' => 'ID Number']) ?>
         </div>
        </div>
          
        <div class='row'> 
         <div class="col-md-4">
            <?= $form->field($identification, 'firstname')->textInput(['maxlength' => true, 'placeholder' => 'Firstname']) ?> 
         </div>
         <div class="col-md-4">
             <?= $form->field($identification, 'middlename')->textInput(['maxlength' => true, 'placeholder' => 'Middlename']) ?>
         </div>
         <div class="col-md-4">
             <?= $form->field($identification, 'lastname')->textInput(['maxlength' => true, 'placeholder' => 'Lastname']) ?>
         </div>
        </div>

        <div class='row'> 
          <div class="col-md-4">
            <?php echo $form->field($identification, 'gender')->dropDownlist([
                    '' => 'Select a Gender',
                    UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
                    UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
                ]) 
            ?> 
         </div>
         <div class="col-md-4">
             <?= $form->field($identification, 'dob')->widget(\kartik\datecontrol\DateControl::classname(), [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Date of bith',
                        'autoclose' => true
                    ]
                ],
            ]); ?>
         </div>
         <div class="col-md-4">
            <?= $form->field($identification, 'nationality')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('id')->asArray()->all(), 'id', 'cc_description'),
                'options' => ['placeholder' => 'Country'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?> 
         </div>
        </div>
        
        <div class="row">
              <div class="col-md-4">
                <?= $form->field($address, 'province_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(SProvince::find()->orderBy('province')->asArray()->all(), 'id', 'province'),
                'theme' => Select2::THEME_KRAJEE, 
                            'options'=>[
                                'id' => 'province_id',
                                'placeholder'=>Yii::t('app', 'Choose Province'),
                                'onchange'=>'
                                $.post( "'.Url::to(['/s-district/lists', 'id' => '']).'"+$(this).val(),function(data){
                                 $("#district_id" ).html(data);
                                });'
                            ],
                            'language' => 'en',
                            'pluginOptions'=>['alloweClear'=>true],
                ]); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($address, 'district_id')->widget(Select2::class,[
                'data' => ArrayHelper::map(SDistrict::find()->orderBy('district')->asArray()->all(), 'id', 'district'),
                'theme' => Select2::THEME_KRAJEE, 
                'options'=>[
                    'id' => 'district_id',
                    'placeholder'=>'Select a district',
                    'onchange'=>'
                        $.post( "'.Url::to(['/s-geo-sector/lists', 'id' => '']).'"+$(this).val(),function(data){
                        $("#sector_id" ).html(data);
                    });'
                ],
                'language' => 'en',
                'pluginOptions'=>['alloweClear'=>true],
                ]);
                ?>  
            </div>
           
            <div class="col-md-4">
                <?= $form->field($address, 'sector_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(SGeosector::find()->orderBy('sector')->asArray()->all(), 'id', 'sector'),
                'options' => ['id' => 'sector_id','placeholder' => Yii::t('app', 'Choose a Sector')],
                'pluginOptions' => [
                'allowClear' => true
                ],
                ]); ?>
            </div>
        </div>
        <div class='row'> 
         <div class="col-md-4">
             <?= $form->field($identification, 'marital_status')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SMaritalStatus::find()->orderBy('id')->asArray()->all(), 'id', 'status'),
                'options' => ['placeholder' => 'Marital status'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
         </div>
    
         <div class="col-md-4">
             <?= $form->field($identification, 'disability_id')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SDisability::find()->orderBy('id')->asArray()->all(), 'id', 'disability'),
                'options' => ['placeholder' => 'Disability'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

         </div>
        </div>

       
            
        <?php kak\widgets\fieldset\FieldSet::end(); ?>




