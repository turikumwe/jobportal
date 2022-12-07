<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsco08Level3 */
?>
<div class="sisco08-level3-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'level2_id',
            'code',
            'cat3_description',
        ],
    ]) ?>

</div>
