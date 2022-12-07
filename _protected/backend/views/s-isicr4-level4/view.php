<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsicr4Level4 */
?>
<div class="sisicr4-level4-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'level3_id',
            'code',
            'ecosector',
        ],
    ]) ?>

</div>
