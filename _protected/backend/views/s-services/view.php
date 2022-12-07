<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SServices */
?>
<div class="sservices-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'created_by',
            'created_at',
            'updated_at',
            'updated_by',
            'deleted_at',
            'deleted_by',
        ],
    ]) ?>

</div>
