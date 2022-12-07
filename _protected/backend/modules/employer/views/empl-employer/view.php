<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmplEmployer */
?>
<div class="empl-employer-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'company_name',
            'company_name_abbraviatio',
            // 'avatar_path',
            // 'avatar_base_url:url',
            // 'parent',
            // 'child',
            [   
                'attribute' => 'Employer type',
                'value' => isset($model->employerType->type) ? $model->employerType->type : '-',
            ],
            'opening_date',
            [   
                'attribute' => 'Registration authority',
                'value' => isset($model->registrationAuthority->registrationauthority) ? $model->registrationAuthority->registrationauthority : '-',
            ],
            'tin',
            [   
                'attribute' => 'Ownership',
                'value' => isset($model->ownership->ownership) ? $model->ownership->ownership : '-',
            ],
            // 'show_address',
            // 'show_economic_sector',
            // 'show_employer_status',
            // 'show_reference',
            // 'show_employer_summary',
            // 'show_manager',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
