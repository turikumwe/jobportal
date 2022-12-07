<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceInternship */
?>
<div class="service-internship-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'employer',
            'employer_description:ntext',
            'internship_name',
            'internship_description:ntext',
            'positions_number',
            'intern_duties:ntext',
            'intern_responsability:ntext',
            'intern_skill_requirement:ntext',
            [   
                'attribute' => 'Economic sector',
                'value' => isset($model->economicSector->ecosector) ? $model->economicSector->ecosector : '-',
            ],
            [   
                'attribute' => 'Education level',
                'value' => isset($model->educationLevel->level) ? $model->educationLevel->level : '-',
            ],
            [   
                'attribute' => 'Education field',
                'value' => isset($model->educationField->field) ? $model->educationField->field : '-',
            ],
            'publication_date',
            'closure_date',
            'how_to_apply:ntext',
            'contact_phone',
            'contact_email:email',
            'any_further_information:ntext',
            [   
                'attribute' => 'Action taken',
                'value' => isset($model->action->action) ? $model->action->action : '-',
            ],
            [   
                'attribute' => 'District',
                'value' => isset($model->district->district) ? $model->district->district : '-',
            ],
            // 'posted',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
