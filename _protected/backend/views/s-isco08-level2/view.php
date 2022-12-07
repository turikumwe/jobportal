<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsco08Level2 */
?>
<div class="sisco08-level2-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'level1_id',
            'cat2_description',
        ],
    ]) ?>

</div>
