<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsced11Level3 */
?>
<div class="sisced11-level3-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'level2_id',
            'code',
            'subcategory_cat3',
        ],
    ]) ?>

</div>
