<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsLanguage */
?>
<div class="js-language-view" style="color:black">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Job Seeker',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            [   
                'attribute' => 'language',
                'value' => isset($model->language0->language) ? $model->language0->language : '-',
            ],
            [   
                'attribute' => 'reading',
                'value' => isset($model->reading0->languagerate) ? $model->reading0->languagerate : '-',
            ],
            [   
                'attribute' => 'writing',
                'value' => isset($model->writing0->languagerate) ? $model->writing0->languagerate : '-',
            ],
            [   
                'attribute' => 'listening',
                'value' => isset($model->listening0->languagerate) ? $model->listening0->languagerate : '-',
            ],
            [   
                'attribute' => 'speaking',
                'value' => isset($model->speaking0->languagerate) ? $model->speaking0->languagerate : '-',
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
