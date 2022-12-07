<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\JsDrivingLicense */
?>
<div class="js-driving-license-update">

    <?= $this->render('_update', [
        'model' => $model,
        'modelsrequestdetail'=>$modelsrequestdetail,
    ]) ?>

</div>
