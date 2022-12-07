<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsTrainingsApplication */
?>
<div class="js-trainings-application-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Training applicant',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'Training title',
                'value' => isset($model->training->training_name) ? $model->training->training_name : '-',
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
