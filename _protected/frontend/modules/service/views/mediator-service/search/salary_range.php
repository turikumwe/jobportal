<?php 
use yii\bootstrap\ActiveForm;
use \yii\widgets\ListView;
use yii\bootstrap\Html;
?>
<div class="panel widget light-widget panel-bd-top">
    <div class="panel-heading no-title">
        <center>
        <h4>
            <b>Salary Range(frw)</b></h4>
        </center> 
    </div>
    <div class="panel-body tags">
    <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['index'],
            ]) ?>
		        <?= $form->field($searchModel, 'from')
                    ->textInput(['placeholder' => $searchModel->getAttributeLabel('from')])
                    ->label(false)
                ?>
                <?= $form->field($searchModel, 'to')
                    ->textInput(['placeholder' => $searchModel->getAttributeLabel('to')])
                    ->label(false)
                ?>

                <div class="form-group text-center">
                    <?= Html::submitButton(Yii::t('project', 'Search'), ['class' => 'btn btn-primary col-sm-6']) ?>
                </div>
    <?php ActiveForm::end() ?>
	</div>
</div>