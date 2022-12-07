<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsJobApplication */
?>
<style>
    .modal-header {
        background-color: #e3e3e3;
    }

     .modal-footer {
        position:absolute;
        bottom:0;
        left:0;
        right:0;
        background-color: #e3e3e3;
        height: 50px;
    }

    .modal-dialog {
        position:absolute;
        top:50% !important;
        transform: translate(0, -50%) !important;
        -ms-transform: translate(0, -50%) !important;
        -webkit-transform: translate(0, -50%) !important;
        margin:auto 20%;
        width:60%;
        height:80%;
        overflow-y: auto;
    }

</style>
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
<br>
</div>
