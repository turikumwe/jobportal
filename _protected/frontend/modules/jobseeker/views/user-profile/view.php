<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
?>
<div class="user-profile-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'firstname',
            // 'middlename',
            'lastname',
            // 'avatar_path',
            // 'avatar_base_url:url',
            // 'locale',
            [   
                'attribute' => 'gender',
                'value' => function($model){
                    return ($model->gender == \common\models\UserProfile::GENDER_MALE) ? 'Male' : "Female" ;
                }
            ],
            [   
                'attribute' => 'document_type',
                'value' => function($model){
                    return isset($model->documentType->documenttype) ? $model->documentType->documenttype : "-" ;
                }
            ],
            'id_number',
            'passport_number',
            'dob',
            [   
                'attribute' => 'nationality',
                'value' => function($model){
                    return isset($model->nationality0->cc_description) ? $model->nationality0->cc_description : "-" ;
                }
            ],
            [   
                'attribute' => 'marital_status',
                'value' => function($model){
                    return isset($model->maritalStatus->status) ? $model->maritalStatus->status : "-" ;
                }
            ],
            [   
                'attribute' => 'disabled',
                'value' => function($model){
                    return isset($model->disability->disability) ? $model->disability->disability : "-" ;
                }
            ],
            [   
                'attribute' => 'disability_id',
                'value' => function($model){
                    return isset($model->disability->disability) ? $model->disability->disability : "-" ;
                }
            ],
            // 'terminate',
            // 'show_education',
            // 'show_experience',
            // 'show_profile_summary',
            // 'show_contact',
            // 'show_skill',
            // 'created_by',
            // 'created_at',
            // 'deleted_by',
            // 'deleted_at',
            // 'updated_by',
            // 'updated_at',
        ],
    ]) ?>

</div>
