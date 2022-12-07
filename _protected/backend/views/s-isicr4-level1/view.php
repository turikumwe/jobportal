<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SIsicr4Level1 */
?>
<div class="sisicr4-level1-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'activities_id',
            'activities_description',
        ],
    ]) ?>

</div>
