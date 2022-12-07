<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmplSummary */
?>
<div class="empl-summary-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Employer',
                'value' => isset($model->employer->company_name) ? $model->employer->company_name : '-',
            ],
            'professional_profile:ntext',
            'specialty:ntext',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
