<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MdEmployees */
?>
<div class="md-employees-view" style="color:black">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Mediator',
                'value' => isset($model->mediator->madiator_name) ? $model->mediator->madiator_name : '-',
                
            ],
            [   
                'attribute' => 'Manager',
                'value' => isset($model->person->first_name) ? $model->person->first_name : '-',
                
            ],
            'start_date',
            'end_date',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
