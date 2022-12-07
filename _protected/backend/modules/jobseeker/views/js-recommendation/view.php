<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsRecommendation */
?>
<div class="js-recommendation-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',            
            [   
                'attribute' => 'Job Seeker',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            'recommendation:ntext',
            [   
                'attribute' => 'Recommended by',
                'value' => isset($model->whoRecommended->userProfile->fullName) ? $model->whoRecommended->userProfile->fullName : '-',

            ],
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
