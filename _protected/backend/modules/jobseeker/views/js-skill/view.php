<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsSkill */
?>
<div class="js-skill-view">
 
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
            [   
                'attribute' => 'Skill level',
                'value' => isset($model->skillLevel->level) ? $model->skillLevel->level : '-',
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
