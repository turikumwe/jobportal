<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\JsDrivingLicense */

?>
<div class="js-driving-license-create">
    <?= $this->render('_form', [
        'model' => $model,
        'categories'=>$categories,
    ]) ?>
</div>
