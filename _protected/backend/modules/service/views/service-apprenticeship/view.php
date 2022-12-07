<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceApprenticeship */
?>
<div class="service-apprenticeship-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Apprenticeship category',
                'value' => isset($model->apprenticeshipCategory->trainingcategory) ? $model->apprenticeshipCategory->trainingcategory : '-',
            ],
            'apprenticeship_name',
            'apprenticeship_details:ntext',
            'apprenticeship_duration',
            'application_deadline',
            'start_date',
            'apprenticeship_center',
            'apprenticeship_provider',
            'posted',
            [   
                'attribute' => 'District',
                'value' => isset($model->district->district) ? $model->district->district : '-',
            ],
            [   
                'attribute' => 'Action',
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
