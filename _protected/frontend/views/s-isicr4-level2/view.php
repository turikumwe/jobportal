<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsicr4Level2 */
?>
<div class="sisicr4-level2-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'level1_id',
            'isic_sector_letter',
            'code',
            'isic_sector_descr',
        ],
    ]) ?>

</div>
