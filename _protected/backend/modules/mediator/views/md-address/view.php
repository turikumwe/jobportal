<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MdAddress */
?>
<div class="md-address-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Mediator',
                'value' => isset($model->mediator->madiator_name) ? $model->mediator->madiator_name : '-' ,
            ],
            [   
                'attribute' => 'Sector',
                'value' => isset($model->geoSector->sector) ? $model->geoSector->sector : '-',
            ],
            'email_address:email',
            'phone_number',
            'pobox',
            'physical_address',
            // 'current_address',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
