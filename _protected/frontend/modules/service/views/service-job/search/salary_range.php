<?php 
use yii\bootstrap\ActiveForm;
use \yii\widgets\ListView;
use yii\bootstrap\Html;
?>
<div class="panel widget light-widget panel-bd-top">
    <div class="panel-heading">
        <center>
        <h4>
            <b><?= Yii::t("frontend","Salary Range") ?> (frw)</b></h4>
        </center> 
    </div>
    <div class="panel-body tags">
    <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['index'],
            ]) ?>
		        <?= $form->field($searchModel, Yii::t("frontend",'from'))
                    ->textInput(['placeholder' => $searchModel->getAttributeLabel('from')])
                    ->label(false)
                ?>
                <?= $form->field($searchModel, Yii::t("frontend",'to'))
                    ->textInput(['placeholder' => $searchModel->getAttributeLabel('to')])
                    ->label(false)
                ?>

                <div class="form-group text-center">
                    <?= Html::submitButton(Yii::t('frontend', 'Search'), ['class' => 'btn btn-primary col-sm-6']) ?>
                </div>
    <?php ActiveForm::end() ?>
	</div>
</div>