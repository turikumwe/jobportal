<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceEventSharing */
?>
<div class="service-event-sharing-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'user_id',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            // 'job_seeker_id',
            [   
                'attribute' => 'job_seeker_id',
                'value' => isset($model->jobSeeker->userProfile->fullName) ? $model->jobSeeker->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'event_id',
                'value' => isset($model->event->event_title) ? $model->event->event_title : '-',
            ],
            'message:ntext',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
