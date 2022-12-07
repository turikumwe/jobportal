<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SDistrictMediatorr */
?>
<div class="sdistrict-mediatorr-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',            
            [   
                'attribute' => 'District',
                'value' => isset($model->district->district) ? $model->district->district : '-',
            ],
            [   
                'attribute' => 'Mediator',
                'value' => isset($model->mediator->madiator_name) ? $model->mediator->madiator_name : '-',
            ],
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
