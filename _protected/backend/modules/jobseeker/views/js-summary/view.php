<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsSummary */
?>
<div class="js-summary-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Job Seeker',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            'professional_profile:ntext',
            'specialty:ntext',
            'createdBy.username',
            'created_at'
        ],
    ]) ?>

</div>
