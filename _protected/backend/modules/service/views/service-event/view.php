<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceEvent */
?>
<div class="service-event-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'event_title',
            [   
                'attribute' => 'event_category_id',
                'value' => isset($model->eventCategory->category) ? $model->eventCategory->category : '-',
            ],
            'event_summary:ntext',
            'event_requirement:ntext',
            'event_location',
            'start_date',
            'closure_date',
            'how_to_apply:ntext',
            'contact_phone',
            'contact_email:email',
            // 'posted',
            [   
                'attribute' => 'action_id',
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
