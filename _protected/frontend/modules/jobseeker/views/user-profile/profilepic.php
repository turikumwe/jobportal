 <?php
 use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
 ?>
<?php
    $model = new common\models\UserProfile;  
  $form = ActiveForm::begin(['action' => Yii::$app->link->frontendUrl('/jobseeker/user-profile/upload')]) ?>
 
             <div class="col-sm-6">
                <?php
                    // echo $form->field($model, 'picture')->widget(
                    //     Upload::class,
                    //     [
                    //         'url' => ['avatar-upload'],
                    //         'maxFileSize' => 2 * 1024 * 1024, //5M
                    //         'maxNumberOfFiles' => 1,
                    //         'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(png)$/i'),
                    //     ]
                    // )
                    echo $form->field($model, 'profile')->fileInput();
                ?>
                <span style="font-size: 12px;font-style: italic">Only PNG image is accepted</span> |
                <span style="font-size: 12px;font-style: italic">Maximum file size is 2MB</span>
                 <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Update') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	  
            </div>
         <?php ActiveForm::end(); ?>      
 