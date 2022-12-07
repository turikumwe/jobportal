<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsEventApplication */
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

    }

</style>
<div class="js-event-application-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'user_id',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'even_id',
                'value' => isset($model->even->event_title) ? $model->even->event_title : '-',
                'visible' => isset($model->even->event_title) ?true :false,
            ],
            'motivation:ntext',
            'application_date',
            [   
                'attribute' => 'area_of_expertise_id',
                'value' => isset($model->areaOfExpertise->expertise) ? $model->areaOfExpertise->expertise : '-',
                'visible' => isset($model->areaOfExpertise->expertise) ?true :false,
            ],
            [   
                'attribute' => 'employment_status_id',
                'value' => isset($model->employmentStatus->status) ? $model->employmentStatus->status : '-',
                'visible' => isset($model->employmentStatus->status) ?true :false,
            ],
            [   
                'attribute' => 'special_assistance_id',
                'value' => isset($model->specialAssistance->assistance) ? $model->specialAssistance->assistance : '-',
                'visible' => isset($model->specialAssistance->assistance) ?true :false,
            ],
            [   
                'attribute' => 'status_id',
                'value' => isset($model->status->status) ? $model->status->status : '-',
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
