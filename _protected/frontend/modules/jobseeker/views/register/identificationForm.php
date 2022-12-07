    <?php

    use Common\models\UserProfile;
    use backend\models\SGeosector;
    use backend\models\SProvince;
    use backend\models\SDistrict;
    use \yii\helpers\ArrayHelper;
    use yii\helpers\Url;
    use yii\jui\DatePicker;

    if (isset($model->province_id)) {

        $model->district_id = SDistrict::find()->where(['province_id' => $model->province_id])['district_id'];
        $model->sector_id   = SGeosector::find()->where(['district_id' => $model->district_id])['sector_id'];
    }
    ?>

    <fieldset> 
        <div>
        <div class="input-text">
            <div class="input-div">
                <?php //echo Yii::$app->label::helper($identification,'document_type')
                ?>
                <?= $form->field($identification, 'document_type')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SDocumenttype::find()->orderBy('id')->asArray()->all(), 'id', 'documenttype'),
                    [
                        'id' => 'userprofile-document_type',
                        'prompt' => Yii::t('frontend', 'Select Document Type'),
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
                            });
                        '
                    ]
                )->label(Yii::t('frontend', 'Document type') . ' <sup><span style="color:red">*</span></sup>') ?>   
            </div>
            <div class="input-div" id='passport' style='display:none'>
                <?= $form->field($identification, 'passport_number')->textInput(['maxlength' => true, 'placeholder' => 'Passport number']) ?>
            </div>
            <div class="input-div" id='nid' style='display:none'>
                <?= $form->field($identification, 'id_number')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('frontend', 'ID Number'),
                    'class' => 'form-inline',
                    'onchange' => '
                                    $.post( "' . Url::to(['nid', 'id' => '']) . '"+$(this).val(),function(data){
                                        var arry = data.split("*");
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
            <div class="input-div" id="go" style="display: none;">
                <input type="button" class="button" name="go" value="Go">
            </div>
        </div>
        <div id='identification' style='display:none'>
            <div class='input-text'>
                <div class="input-div">
                    <?= $form->field($identification, 'firstname')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'First name'), 'readOnly' => TRUE])->label(Yii::t('frontend', 'First Name') . ' <sup><span style="color:red">*</span></sup>') ?>   
                </div>
                <div class="input-div">
                    <?= $form->field($identification, 'middlename')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Middle name'), 'readOnly' => TRUE]) ?>
                </div>
                <div class="input-div">
                    <?= $form->field($identification, 'lastname')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Last name'), 'readOnly' => TRUE])->label(Yii::t('frontend', 'Last name') . ' <sup><span style="color:red">*</span></sup>') ?>   
                </div>
            </div>
            <div class='input-text'>
                <div class="input-div">
                    <?php echo $form->field($identification, 'gender')->dropDownlist([
                        '' => 'Select Gender',
                        UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
                        UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
                    ], ['readOnly' => TRUE])->label(Yii::t('frontend', 'Gender') . ' <sup><span style="color:red">*</span></sup>') ?> 
                     
                </div>
                <div class="input-div">
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
                    ], ['readOnly' => TRUE])->label(Yii::t('frontend', 'Birthday Date') . ' <sup><span style="color:red">*</span></sup>') ?> 
                </div>
            </div>
        </div>
        <div id='passportinfo' style='display:none'>
            <div class='input-text'>
                <div class="input-div">
                    <?= $form->field($identification, 'pfirstname')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'First name')])->label(Yii::t('frontend', 'First Name') . ' <sup><span style="color:red">*</span></sup>') ?> 
                </div>
                <div class="input-div">
                    <?= $form->field($identification, 'pmiddlename')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Middle name')]) ?>
                </div>
                <div class="input-div">
                    <?= $form->field($identification, 'plastname')->textInput(['maxlength' => true, 'placeholder' => Yii::t('frontend', 'Last name')])->label(Yii::t('frontend', 'Last Name') . ' <sup><span style="color:red">*</span></sup>') ?> 
                </div>
            </div>
            <div class='input-text'>
                <div class="input-div">
                    <?php echo $form->field($identification, 'pgender')->dropDownlist([
                        '' => 'Select Gender',
                        UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
                        UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
                    ])->label(Yii::t('frontend', 'Gender') . ' <sup><span style="color:red">*</span></sup>') ?> 
                </div>
                <div class="input-div">
                    <?= $form->field($identification, 'pdob')->widget(DatePicker::classname(), [
                        'language' => 'en',
                        'dateFormat' => 'yyyy-MM-dd',
                    ])
                    ?>
                </div>
            </div>
        </div>
        <div class="input-text">
            <div class="input-div">
                <?= $form->field($address, 'province_id')->dropDownList(
                    ArrayHelper::map(SProvince::find()->orderBy('province')->where(['!=', 'id', 6])->asArray()->all(), 'id', 'province'),
                    [
                        'id' => 'province_id',
                        'prompt' => Yii::t('frontend', 'Select Province'),
                        'onchange' => '
                            $.post( "' . Url::to(['/s-district/lists', 'id' => '']) . '"+$(this).val(),function(data){
                                $( "#district_id" ).html( data );
                            });
                        '
                    ]
                )->label(Yii::t('frontend', 'Province') . ' <sup><span style="color:red">*</span></sup>') ?> 
            </div>
            <div class="input-div">
                <?= $form->field($address, 'district_id')->dropDownList(
                    ArrayHelper::map(SDistrict::find()->orderBy('district')->where(['!=', 'province_id', 6])->asArray()->all(), 'id', 'district'),
                    [
                        'id' => 'district_id',
                        'prompt' => Yii::t('frontend', 'Select District'),
                        'onchange' => '
                            $.post( "' . Url::to(['/s-geo-sector/lists', 'id' => '']) . '"+$(this).val(),function(data){
                            $("#sector_id" ).html(data);
                        });'
                    ]
                )->label(Yii::t('frontend', 'District') . ' <sup><span style="color:red">*</span></sup>') ?> 
            </div> 
            <div class="input-div">
                <?= $form->field($address, 'sector_id')->dropDownList(
                    ArrayHelper::map(SGeosector::find()->orderBy('sector')->where(['!=', 'district_id', 61])->asArray()->all(), 'id', 'sector'),
                    [
                        'id' => 'sector_id',
                        'prompt' => Yii::t('frontend', 'Select Sector')
                    ]
                )->label(Yii::t('frontend', 'Sector') . ' <sup><span style="color:red">*</span></sup>') ?> 
            </div>
            </div>
        
        <div class="input-text">
            <div class="input-div">
                <?= $form->field($identification, 'marital_status')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SMaritalStatus::find()->orderBy('id')->asArray()->all(), 'id', 'status'),
                    ['prompt' => Yii::t('frontend', 'Select Marital Status')]
                )->label(Yii::t('frontend', 'Martial Status') . ' <sup><span style="color:red">*</span></sup>') ?> 
            </div>
            <div class="input-div">
                <?= $form->field($identification, 'disability_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SDisability::find()->orderBy('id')->asArray()->all(), 'id', 'disability'),
                    ['prompt' => Yii::t('frontend', 'Select Disability')]
                )->label(Yii::t('frontend', 'Disability') . ' <sup><span style="color:red">*</span></sup>') ?> 
            </div>
            <div class="input-div">
                <?= $form->field($identification, 'nationality')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('id')->asArray()->all(), 'id', 'cc_description'),
                    ['prompt' => Yii::t('frontend', 'Select Country')]
                )->label(Yii::t('frontend', 'Nationality') . ' <sup><span style="color:red">*</span></sup>') ?> 
            </div></div>
        </div> 
    </fieldset>