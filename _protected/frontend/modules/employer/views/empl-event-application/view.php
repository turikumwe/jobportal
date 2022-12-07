<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmplEventApplication */
?>
<div class="empl-event-application-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'employer_id',
                'value' => isset($model->employer->company_name) ? $model->employer->company_name : '-',
            ],
            [   
                'attribute' => 'even_id',
                'value' => isset($model->even->event_title) ? $model->even->event_title : '-',
            ],
            'motivation:ntext',
            'application_date',
            [   
                'attribute' => 'status_id',
                'value' => isset($model->status->status) ? $model->status->status : '-',
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
