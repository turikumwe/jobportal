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
                'value' => isset($model->drivingLicense->user->userProfile->fullName) ? $model->drivingLicense->user->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'license_category_id',
                'value' => isset($model->licenseCategory->category) ? $model->licenseCategory->category : '-',
            ],                       
            'issued_date',        
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
