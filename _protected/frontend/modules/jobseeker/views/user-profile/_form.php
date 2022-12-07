<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\select2\Select2;
//use trntv\filekit\widget\Upload;
/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */
$url = (Yii::$app->user->can('user')) ? '/jobseeker/user-profile/update' : '/jobseeker/user-profile/update?idOtherProfile='.$_GET['js'];
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl($url)]); ?>
    <table class='table'>
       <!--  <tr style='background-color: #f5f5f5'>
            <td colspan='3' >
                <?php /*echo $form->field($model, 'picture')->widget(
                            Upload::class,
                            [
                                'url' => ['avatar-upload']
                            ]
                )*/?> 
            </td>
        </tr> -->

        <tr>
            <td>
            <?= $form->field($model, 'document_type')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SDocumenttype::find()->orderBy('id')->asArray()->all(), 'id', 'documenttype'),
                'options' => [
                    'placeholder' => 'Document type',
                    'onchange'=>'',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'disabled' => false
                ],
            ]); ?>
            </td>
            </tr>
<tr>

            <td> <?= $form->field($model, 'id_number')->textInput(['maxlength' => true, 'readOnly' => false]) ?></td>
</tr>
<tr>
            <td> <?= $form->field($model, 'passport_number')->textInput(['maxlength' => true, 'readOnly' => false]) ?></td>
  
        </tr>
    
        <tr>
            <td>
                <?= $form->field($model, 'firstname')->textInput(['maxlength' => true, 'readOnly' => false]) ?>
                <?php if(Yii::$app->user->can('user')) { ?>
                </tr>
<tr>
         <td>           <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->id])->label(false) ?>
                <?php  } else { ?>
                    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
                <?php } ?>
            </td>
</tr>
<tr>
            <td>
                <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>
            </td>
            </tr>
<tr>
            <td>
                <?= $form->field($model, 'lastname')->textInput(['maxlength' => true, 'readOnly' => false]) ?>
            </td>
    </tr>
    
    <tr>
         <td>  
            <?php echo $form->field($model, 'gender')->dropDownlist(
                [
                    \common\models\UserProfile::GENDER_FEMALE => Yii::t('frontend', 'Female'),
                    \common\models\UserProfile::GENDER_MALE => Yii::t('frontend', 'Male')
                ], 
                ['prompt' => '', 'disabled' => false]
            ) ?>
            
        </td>
        </tr>
<tr>

        <td> <?= $form->field($model, 'dob')->textInput(['readOnly' => false]) ?></td>
</tr>
<tr>
        <td><?= $form->field($model, 'phone_number')->textInput() ?></td>
    </tr>

    <tr>
        <td>
            <?= $form->field($model, 'nationality')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SCountrycodeIso3166::find()->orderBy('id')->asArray()->all(), 'id', 'cc_description'),
                'options' => ['placeholder' => 'Country'],
                'pluginOptions' => [
                    'allowClear' => false,
                    'disabled' => false
                ],
            ]); ?> 
            
        </td>
</tr>
<tr>
        <td><?= $form->field($model, 'marital_status')->widget(\kartik\widgets\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\SMaritalStatus::find()->orderBy('id')->asArray()->all(), 'id', 'status'),
                'options' => ['placeholder' => 'Marital status'],
                'pluginOptions' => [
                     
                    'disabled' => false
                ],
            ]); ?>

        <td>&nbsp;</td>
        
    </tr>
</table>
 
<div class='well'>       
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>
</div>
    <?php ActiveForm::end(); ?>
    
</div>
