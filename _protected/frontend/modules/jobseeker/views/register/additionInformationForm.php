    <?php

    use Common\models\UserProfile;
    use backend\models\SGeosector;
    use backend\models\SProvince;
    use backend\models\SDistrict;
    use \yii\helpers\ArrayHelper;
    use yii\helpers\Url;
    use yii\jui\DatePicker;


    ?>

    <fieldset>
         
        <div class="inline__flds">
            <div class="input__fld">
                <?= $form->field($identification, 'idKnownThrough')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\SKoraKnownThrough::find()->orderBy('id')->asArray()->all(), 'id', 'through'),
                    [
                        'prompt' => Yii::t('frontend', 'Kindly select'),
                        'onchange' => '
                            // To get dropdownlist

                            var id = document.getElementById("userprofile-idknownthrough").value;
                            if(id == 5){
                                $("#othersourceofinformation").show();
                            }else{
                                $("#othersourceofinformation").hide();
                            }
                        '

                ]
                )->label(Yii::t('frontend', 'I know KORA through') . ' <sup><span style="color:red">*</span></sup>') ?> 
            </div>
            <div class="input__fld" id='othersourceofinformation' style='display:none'>
                <?= $form->field($identification, 'otherKnownThrough')->textInput(['maxlength' => true, 'placeholder' => 'Known through']) ?>
            </div>
            <div class="input__fld">
                <?= $form->field($identification, 'idAreaOfInterest')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\common\models\SOccupationGrouping::find()->where(['not in', 'id', ['99']])->orderBy(['id'=>SORT_DESC])->asArray()->all(), 'id', 'occupation_grouping'),
                    ['prompt' => Yii::t('frontend', 'Select your area of interest')]
                ); ?>
            </div>
        </div>
    </fieldset>