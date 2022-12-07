<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsEducation */
?>
<div class="js-education-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [   
                'attribute' => 'Job Seeker',
                'value' => isset($model->user->userProfile->fullName) ? $model->user->userProfile->fullName : '-',
            ],
            'school',
            [   
                'attribute' => 'Country',
                'value' => isset($model->country->cc_description) ? $model->country->cc_description : '-',
            ],
            [   
                'attribute' => 'Education level',
                'value' => isset($model->educationLevel->level) ? $model->educationLevel->level : '-',
            ],
            [   
                'attribute' => 'Education level',
                'value' => isset($model->educationField->field) ? $model->educationField->field : '-',
            ],
            'exact_quali',
            'start_date',
            'end_date',
            [   
                'attribute' => 'Grade',
                'value' => isset($model->grade->grade) ? $model->grade->grade : "-",
            ],
            [   
                'attribute' => 'Certificate',
                'value' => isset($model->certificate->certificate) ? $model->certificate->certificate : '-',
            ],
            'certificate_path',
            'certificate_base_url:url',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
