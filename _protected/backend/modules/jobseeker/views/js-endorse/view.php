<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsEndorse */
?>
<div class="js-endorse-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Job Seeker',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'Skill',
                'value' => isset($model->skill->skill) ? $model->skill->skill : '-',
            ],
            'who_endorsed_id',
            [   
                'attribute' => 'Endorsed by',
                'value' => isset($model->whoEndorsed->userProfile->fullName) ? $model->whoEndorsed->userProfile->fullName : '-',

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
