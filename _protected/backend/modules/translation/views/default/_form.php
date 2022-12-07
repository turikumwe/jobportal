<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

use \yii\helpers\ArrayHelper;
use \kartik\widgets\Select2;
use backend\modules\translation\models\Category;

/**
 * @var $this      yii\web\View
 * @var $model     \common\base\MultiModel
 * @var $languages array
 */

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model->getModel('source'), 'category')->dropdownList
    (
        ArrayHelper::map(Category::find()->all(),'id','category'),
        ['prompt'=>'Select category']
    ) 
    ->label(Yii::t('backend','Category')); 
?>

<?php echo $form->field($model->getModel('source'), 'message')->textInput() ?>

<?php if (!$model->getModel('source')->isNewRecord) { ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo Yii::t('backend', 'Translations') ?></h3>
        </div>
        <div class="panel-body">
            <?php foreach ($languages as $language => $name) {
                echo $form->field($model->getModel($language), 'translation')->textInput([
                    'id' => $language . '-translation',
                    'name' => $language . '[translation]',
                ])->label($name);
            } ?>
        </div>
    </div>
<?php } ?>

<div class="form-group">
    <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
