<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsEndorse */
?>
<div class="js-endorse-view"  style="color:black">
 
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
                'attribute' => 'Endorsed by',
                'value' => isset($model->whoEndorsed->mediatorProfile->madiator_name) ? $model->whoEndorsed->mediatorProfile->madiator_name : '-',
                'visible' => isset($model->whoEndorsed->mediatorProfile->madiator_name) ? true : false,
            ],

            [   
                'attribute' => 'Endorsed by',
                'value' => isset($model->whoEndorsed->userProfile->fullName) ? $model->whoEndorsed->userProfile->fullName : '-',
                'visible' => isset($model->whoEndorsed->userProfile->fullName) ? true : false,
            ],

            [   
                'attribute' => 'Endorsed by',
                'value' => isset($model->whoEndorsed->employerProfile->company_name) ? $model->whoEndorsed->employerProfile->company_name : '-',
                'visible' => isset($model->whoEndorsed->employerProfile->company_name) ? true : false,
            ],
            
            // [
            // 'class'=>'\kartik\grid\DataColumn',
            // 'attribute'=>'country_id',
            // 'label'=>'Country',
            // 'value'=>$model->country->cc_description,            
            // ],
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
