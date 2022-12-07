<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmplEconomicSector */
?>
<div class="empl-economic-sector-view" style="color:black">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [   
                'attribute' => 'Employer',
                'value' => isset($model->employer->company_name) ? $model->employer->company_name : '-'
            ],
            [   
                'attribute' => 'Economic sector',
                'value' => isset($model->economicSector->ecosector) ? $model->economicSector->ecosector : '-'
            
            ],
            [   
                'attribute' => 'Type of sector',
                'value' => isset($model->mainEconomicSector->sector ) ? $model->mainEconomicSector->sector : '-'
            ],
            'start_date',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
