<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JsCaseManagement */
?>
<div class="js-case-management-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'jobseeker.fullName',
             [
                'attribute' => 'availability',
                'label'     => 'Availability',
                'value' => $model->availability,
                'visible' => ($model->availability) ? $model->availability : false,
            ],
            [
                'attribute' => 'application_id',
                'label'     => 'Job',
                'value' => ($model->applicationJob) ? $model->applicationJob->job->jobtitle : '-',
                'visible' => ($model->applicationJob) ? true : false,
            ],
            [
                'attribute' => 'application_id',
                'label'     => 'Event',
                'value' => ($model->applicationEvent) ? $model->applicationEvent->even->event_title : '-',
                'visible' => ($model->applicationEvent) ? true : false,
            ],

            [
                'attribute' => 'employer',
                'label'     => 'Employer',
                'value' => ($model->applicationJob) ? $model->applicationJob->job->employer : '-',
                'visible' => ($model->applicationJob) ? true : false,
            ],
            [
                'attribute' => 'contact_email',
                'label'     => 'Contact Email',
                'value' => ($model->applicationEvent) ? $model->applicationEvent->even->contact_email : '-',
                'visible' => ($model->applicationEvent) ? true : false,
            ],

            [
                'attribute' => 'opportunity',
                'label'     => 'opportunity',
                'value' => ($model->applicationJob) ? $model->applicationJob->job->opportunity->name : '-',
                'visible' => ($model->applicationJob) ? true : false,
            ],

            [
                'attribute' => 'opportunity',
                'label'     => 'opportunity',
                'value' => ($model->applicationEvent) ? $model->applicationEvent->even->opportunity->name : '-',
                'visible' => ($model->applicationEvent) ? true : false,
            ],
            [
                'attribute' => 'given_service',
                'label'     => 'Service',
                'value' => $model->services->name,
                'visible' => ($model->services->name) ? $model->services->name : false,
            ],

            [
                'attribute' => 'willingness',
                'visible' => ($model->willingness) ? $model->willingness : false,
            ],
            [
                'attribute' => 'license_permit',
                'visible' => ($model->license_permit) ? $model->license_permit : false,
            ],
            
            [
                'attribute' => 'geven_service_description',
                 'value' => $model->geven_service_description,
                'visible' => ($model->geven_service_description) ? $model->geven_service_description : false,
            ],

             [
                'attribute' => 'cooperative',
                'visible' => ($model->cooperative) ? $model->cooperative : false,
            ],

            [
                'attribute' => 'mediotor_id',
                'value' => function($data){
                    if(isset($data->mediotor->employeeProfile))
                        return $data->mediotor->employeeProfile->fullName;
                    else
                        return $data->mediotor->mediatorProfile->madiator_name;

                }
                
            ],
            'created_at',
            // [
            //     'attribute' => 'created_by',
            //     'label'     => 'Submitted By',
            //     'value' => (isset($model->mediotor->employeeProfile)) ? $model->mediotor->employeeProfile->fullName : $model->mediotor->mediatorProfile->madiator_name,
            // ],
        ],
    ]) ?>

</div>
