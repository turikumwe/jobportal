<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmplAddress */
?>
<div class="empl-address-view" style="color: black">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Employer',
                'value' => isset($model->employer->company_name) ? $model->employer->company_name : '-',
            ],
            [   
                'attribute' => 'Sector',
                'value' => isset($model->geoSector->sector) ? $model->geoSector->sector : '-',
            ],
            'email_address:email',
            'phone_number',
            'pobox',
            'website',
            'physical_address',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
