<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmplManagers */
?>
<div class="empl-managers-view" style="color:black">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'person_id',
            [   
                'attribute' => 'Employer',
                'value' => isset($model->employer->company_name) ? $model->employer->company_name : '-',
            ],
            'start_date',
            'end_date',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
