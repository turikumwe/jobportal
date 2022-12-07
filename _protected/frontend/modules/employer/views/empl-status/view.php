<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmplStatus */
?>
<div class="empl-status-view" style="color:black">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [   
                'attribute' => 'Employer',
                'value' => isset($model->employer->company_name) ? $model->employer->company_name : '-'
            ],
            [   
                'attribute' => 'Employer status',
                'value' => isset($model->employerStatus->status) ? $model->employerStatus->status : '-'
            ],
            'status_effective_date',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
