    <?php

    use trntv\filekit\widget\Upload;
    use Common\models\UserProfile;
    use backend\models\SGeosector;
    use backend\models\SProvince;
    use backend\models\SDistrict;
    use \yii\helpers\ArrayHelper;
    use \kartik\widgets\Select2;
    use yii\helpers\Url;
    use yii\helpers\Html;

    if (isset($model->province_id)) {

        $model->district_id = SDistrict::find()->where(['province_id' => $model->province_id])['district_id'];
        $model->sector_id   = SGeosector::find()->where(['district_id' => $model->district_id])['sector_id'];
    }


    ?>

    <?php kak\widgets\fieldset\FieldSet::begin([
        'legend' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('frontend', 'Identification'),
        'active' => true, // false - hide content, default true
        'speed'  => 0, // animation speed default value 300
        'dataUp' => "<i class='glyphicon glyphicon-collapse-up'></i> ",     // template content icon
        'dataDown'  => "<i class='glyphicon glyphicon-collapse-down'></i> ",   // template content icon
    ]); ?>

    <?php
    $disability_id = $form->field($identification, 'disability_id');
    $disability_id->enableClientValidation = false;
    $marital_status = $form->field($identification, 'marital_status');
    $marital_status->enableClientValidation = false;
    ?>

    <div class='row'>

        <div class="col-md-4">
            <?= $form->field($identification, 'document_type')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SDocumenttype::find()->where(['id' => 2])->orderBy('id')->asArray()->all(), 'id', 'documenttype'),
                'options' => [
                    'placeholder' => Yii::t('frontend', 'Select Document Type'),
                    'onchange' => '

                                // To get dropdownlist

                                   var id = document.getElementById("userprofile-document_type").value;
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
                                    });'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false); ?>
        </div>
        <div class="col-md-4" id='passport' style='display:none'>
            <?= $form->field($identification, 'passport_number')->textInput(['maxlength' => true, 'placeholder' => 'Enter Passport Number']) ?>
        </div>
        <div class="col-md-4" id='nid' style='display:none'>
            <?= $form->field($identification, 'id_number')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('frontend', 'ID Number'),
                'class' => 'form-inline',
                'onchange' => '
                                $.post( "' . Url::to(['nid', 'id' => '']) . '"+$(this).val(),function(data){
                                    var arry = data.split("-");
                                    document.getElementById("identification").style.display = "block";
                                    $("#userprofile-firstname").val(arry[0]);
                                    $("#userprofile-lastname").val(arry[1]);
                                    if(arry[3]=="M")
                                        $("#userprofile-gender").val(1);
                                    if(arry[3]=="F")
                                        $("#userprofile-gender").val(2);
                                    
                                    var dt = arry[2].split("/");
                                    var dob = dt[2] + "-" + dt[1] + "-" + dt[0];
                                    $("#userprofile-dob-disp").val(dob);
                                });',
            ]) ?>
        </div>
        <div class="col-md-4" id="go" style="display: none;padding-top: 29px;">
            <input type="button" class="btn btn-primary" name="go" value="Go">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id='identification' style='display:none'>

            <div class='row'>
                <div class="col-md-4">
                    <?= $form->field($identification, 'firstname')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'First name'), 'readOnly' => TRUE]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($identification, 'middlename')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Middle name'), 'readOnly' => TRUE]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($identification, 'lastname')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Last name'), 'readOnly' => TRUE]) ?>
                </div>
            </div>

            <div class='row'>
                <div class="col-md-4">
                    <?php echo $form->field($identification, 'gender')->dropDownlist([
                        '' => 'Select gender',
                        UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
                        UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
                    ], ['readOnly' => TRUE])
                    ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($identification, 'dob')->widget(\kartik\datecontrol\DateControl::classname(), [
                        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                        'saveFormat' => 'php:Y-m-d',
                        'ajaxConversion' => true,
                        'options' => [
                            'pluginOptions' => [
                                'placeholder' => Yii::t('frontend', 'Date of bith'),
                                'autoclose' => true
                            ]
                        ],
                    ], ['readOnly' => TRUE]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-12" id='passportinfo' style='display:none'>

            <div class='row'>
                <div class="col-md-4">
                    <?= $form->field($identification, 'pfirstname')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'First name')]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($identification, 'pmiddlename')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Middle name')]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($identification, 'plastname')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Last name')]) ?>
                </div>
            </div>

            <div class='row'>
                <div class="col-md-4">
                    <?php echo $form->field($identification, 'pgender')->dropDownlist([
                        '' => 'Select a Gender',
                        UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
                        UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
                    ])
                    ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($identification, 'pdob')->widget(\kartik\datecontrol\DateControl::classname(), [
                        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                        'saveFormat' => 'php:Y-m-d',
                        'ajaxConversion' => true,
                        'options' => [
                            'pluginOptions' => [
                                'placeholder' => Yii::t('frontend', 'Date of bith'),
                                'autoclose' => true
                            ]
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-4">
            <?= $form->field($address, 'country_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->where(['!=', 'id', 183])->orderBy('id')->asArray()->all(), 'id', 'cc_description'),
                'options' => ['placeholder' => Yii::t('frontend', 'Select Country')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Country of residence'); ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($linkedinurl, 'url')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('frontend', 'Enter URL'),
                'onChange' => 'removeHttps("linkedinurl-url")'
            ])
                ->label("Professional network URL (LinkedIn, Hire,..)") ?>
        </div>
    </div>

    <script>
        function removeHttps(id) {
            let n = $("#" + id).val().toLowerCase().match('http://');
            if (n != null) {
                let httplink = $("#" + id).val().toLowerCase().replace('http://', '');
                $("#" + id).val(httplink);
            } else {
                let httplink = $("#" + id).val().toLowerCase().replace('https://', '');
                $("#" + id).val(httplink);
            }
        }
    </script>



    <?php kak\widgets\fieldset\FieldSet::end(); ?>