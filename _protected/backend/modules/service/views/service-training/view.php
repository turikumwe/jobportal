<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceTraining */
?>
<div class="service-training-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Job Category',
                'value' => isset($model->trainingCategory->trainingcategory) ? $model->trainingCategory->trainingcategory : '-',
            ],
            'training_name',
            'training_details:ntext',
            'training_duration',
            'application_deadline',
            'start_date',
            'training_center',
            'training_provider',
            // 'posted',
            [   
                'attribute' => 'District',
                'value' => isset($model->district->district) ? $model->district->district : '-',
            ],
            [   
                'attribute' => 'Action taken',
                'value' => isset($model->action->action) ? $model->action->action : '-',
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
