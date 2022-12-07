<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsExperience */
?>
<div class="js-experience-view"  style="color:black">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Job Seeker',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-' ,
            ],
            'company',
            [   
                'attribute' => 'Occupation',
                'value' => isset($model->occupation->occupation) ? $model->occupation->occupation : '-',
            ],
            'exact_position',
            [   
                'attribute' => 'experience_in_this_occupationn',
                'value' => isset($model->experienceInterval->experience_interval) ? $model->experienceInterval->experience_interval: '-',
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
