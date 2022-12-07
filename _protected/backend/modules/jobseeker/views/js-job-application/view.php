<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsJobApplication */
?>
<div class="js-job-application-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Job applicant',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'Job title',
                'value' => isset($model->job->jobtitle) ? $model->job->jobtitle : '-',
            ],
            'motivation:ntext',
            'application_date',
            [   
                'attribute' => 'Application status',
                'value' => isset($model->status->status) ? $model->status->status : '-',
            ],
            'reason_rejection',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
