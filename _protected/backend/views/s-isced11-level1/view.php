<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsced11Level1 */
?>
<div class="sisced11-level1-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'category_cat1',
        ],
    ]) ?>

</div>
