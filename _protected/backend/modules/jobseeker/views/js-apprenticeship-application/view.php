<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsApprenticeshipApplication */
?>
<div class="js-apprenticeship-application-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Apprenticeship applicant',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'Apprenticeship title',
                'value' => isset($model->apprenticeship->apprenticeship_name) ? $model->apprenticeship->apprenticeship_name : '-',
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
