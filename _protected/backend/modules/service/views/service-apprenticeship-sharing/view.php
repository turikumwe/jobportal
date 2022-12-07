<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceApprenticeshipSharing */
?>
<div class="service-apprenticeship-sharing-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'user_id',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'job_seeker_id',
                'value' => isset($model->jobSeeker->userProfile->fullName) ? $model->jobSeeker->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'apprenticeship_id',
                'value' => isset($model->apprenticeship->apprenticeship_name) ? $model->apprenticeship->apprenticeship_name : '-',
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
