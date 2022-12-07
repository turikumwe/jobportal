<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SDistrict */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Sdistrict',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Sdistricts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sdistrict-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
