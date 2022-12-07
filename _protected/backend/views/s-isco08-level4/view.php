<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsco08Level4 */
?>
<div class="sisco08-level4-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'level3_id',
            'occupation',
        ],
    ]) ?>

</div>
