<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceJob */
?>
<div class="service-job-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'employer',
            'jobtitle',
            'job_summary:ntext',
            'job_responsability:ntext',
            'job_skill_requirement:ntext',
            'job_remuneration',
            'positions_number',
            [   
                'attribute' => 'Economic sector',
                'value' => isset($model->economicSector->ecosector) ? $model->economicSector->ecosector : '-',
            ],
            [   
                'attribute' => 'Qualification',
                'value' => isset($model->educationLevel->level) ? $model->educationLevel->level : '-',
            ],
            [   
                'attribute' => 'Education field',
                'value' => isset($model->educationField->field) ? $model->educationField->field : '-',
            ],
            'posting_date',
            'closure_date',
            'how_to_apply:ntext',
            'contact_phone',
            'contact_email:email',
            [   
                'attribute' => 'action_id',
                'value' => isset($model->action->action) ? $model->action->action : '-',
            ], 
            [   
                'attribute' => 'district_id',
                'value' => isset($model->district->district) ? $model->district->district : '-',
            ],
            // 'posted',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
