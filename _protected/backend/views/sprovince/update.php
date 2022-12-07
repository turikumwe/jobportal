<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SProvince */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Sprovince',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Sprovinces'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="sprovince-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
