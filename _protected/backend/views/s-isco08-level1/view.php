<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsco08Level1 */
?>
<div class="sisco08-level1-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cat1_id',
            'cat1_description',
        ],
    ]) ?>

</div>
