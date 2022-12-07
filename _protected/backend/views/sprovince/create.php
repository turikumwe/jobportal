<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SProvince */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Sprovince',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Sprovinces'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sprovince-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
