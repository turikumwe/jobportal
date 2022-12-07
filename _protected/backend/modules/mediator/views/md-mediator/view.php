<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MdMediator */
?>
<div class="md-mediator-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Registration Authority',
                'value' => isset($model->registrationAuthority->registrationauthority) ?  $model->registrationAuthority->registrationauthority : '-',
            ],
            'registration_number',
            'madiator_name',
            [   
                'attribute' => 'Mediator type',
                'value' => isset($model->mediatorType->mediator_type) ? $model->mediatorType->mediator_type : '-',
            ],
            [   
                'attribute' => 'Ownership',
                'value' => isset($model->ownership->ownership) ? $model->ownership->ownership : '-',
            ],
            'opening_date',
            // 'show_address',
            // 'show_manager',
            // 'show_employee',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
