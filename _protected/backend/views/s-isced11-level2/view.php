<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsced11Level2 */
?>
<div class="sisced11-level2-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'level1_id',
            'code',
            'subcategory_cat2',
        ],
    ]) ?>

</div>
