<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Labels */
?>
<div class="labels-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'attribute',
            'definition:ntext',
        ],
    ]) ?>

</div>
