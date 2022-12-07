<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsEventApplication */
?>
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
            ],
            'motivation:ntext',
            'application_date',
            [   
                'attribute' => 'area_of_expertise_id',
                'value' => isset($model->areaOfExpertise->expertise) ? $model->areaOfExpertise->expertise : '-',
            ],
            [   
                'attribute' => 'employment_status_id',
                'value' => isset($model->employmentStatus->status) ? $model->employmentStatus->status : '-',
            ],
            [   
                'attribute' => 'special_assistance_id',
                'value' => isset($model->specialAssistance->assistance) ? $model->specialAssistance->assistance : '-',
            ],
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
