<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SOpportunity */
?>
<div class="sopportunity-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'type',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'deleted_at',
            'deleted_by',
        ],
    ]) ?>

</div>
