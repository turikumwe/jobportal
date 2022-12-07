<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsicr4Level3 */
?>
<div class="sisicr4-level3-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'level2_id',
            'code',
            'isic_group_descr',
        ],
    ]) ?>

</div>
