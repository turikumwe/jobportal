<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsEducation */
?>
<div class="js-driving-license-view" style="color:black">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Job Seeker',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'having_license',
                'value' => isset($model->havingLicense->noyes) ? $model->havingLicense->noyes : '-',
            ],
            [   
                'attribute' => 'license_type_id',
                'value' => isset($model->licenseType->type) ? $model->licenseType->type : '-',
            ],
            [   
                'attribute' => 'country_id',
                'value' => isset($model->country->cc_description) ? $model->country->cc_description : '-',
            ],
            
            
            'expering_date',        
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
