<?php
    use yii\helpers\Url;
?>
<style>
    .modal-header {
        background-color: #e3e3e3;
    }

     .modal-footer {
        position:absolute;
        bottom:10;
        left:0;
        right:0;
        background-color: #e3e3e3;
        height: 50px;
    }

    .modal-dialog {
        position:absolute;
        top:45% !important;
        transform: translate(0, -50%) !important;
        -ms-transform: translate(0, -50%) !important;
        -webkit-transform: translate(0, -50%) !important;
        margin:auto 20%;
        width:60%;

    }

</style>
<?php 
    use yii\widgets\DetailView;
     use yii\helpers\Html;
?>
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'employer',
            [
                'attribute' => 'employer_logo',
                'format' => 'image',
                'value'=>function($model) { return Yii::getAlias('@storageUrl') .'/source/1/'.$model->employerlogo_path; },
                'visible' => isset($model->employerlogo_path) ? true : false,
            ],
            [ 
                'attribute' => 'link', 
                'format' => 'raw', 
                'value' => function ($model) { 
                    return \Yii::$app->formatter->asUrl($model->link, ['target' => '_blank']); 
                },
                'visible' => isset($model->link) ? true : false,
            ],

            [   
                'attribute' => 'Employer description',
                'value' => isset($model->createdBy->employerProfile->emplEmployerSummaries->professional_profile) ? $model->createdBy->employerProfile->emplEmployerSummaries->professional_profile : '-',
                'visible' => isset($model->createdBy->employerProfile->emplEmployerSummaries->professional_profile) ? true : false,
            ],

            [   
                'attribute' => 'jobtitle',
                'value' =>  $model->jobtitle,
                'contentOptions' => ['style' => 'width:50%;'],
            ],
            
            [   
                'attribute' => 'job_type_id',
                'value' => isset($model->jobType->job_type) ? $model->jobType->job_type : '-',
                'visible' => isset($model->jobType->job_type) ? true : false,
            ],
            
            [   
                'attribute' => 'job_summary',
                'value' => $model->job_summary,
                'visible' => isset($model->job_summary) ? true : false,
                'format' => 'raw',
            ],

            [   
                'attribute' => 'Occupation',
                'value' => isset($model->economicSector->occupation) ? $model->economicSector->occupation : '-',
                'visible' => isset($model->economicSector->occupation) ? true : false,
            ],

            [   
                'attribute' => 'job_responsability',
                'value' => $model->job_responsability,
                'visible' => isset($model->job_responsability) ? true : false,
                'format' => 'raw',
            ],

            [   
                'attribute' => 'positions_number',
                'value' => isset($model->positions_number) ? $model->positions_number : '-',
                'visible' => isset($model->positions_number) ? true : false,
            ],

            [   
                'attribute' => 'job_skill_requirement',
                'value' =>  $model->job_skill_requirement,
                'visible' => isset($model->job_skill_requirement) ? true : false,
                'format' => 'raw',
            ],

            [   
                'attribute' => 'job_remuneration',
                'value' => isset($model->job_remuneration) ? $model->job_remuneration : '-',
                'visible' => isset($model->job_remuneration) ? true : false,
            ],
            
            [   
                'attribute' => 'Qualification',
                'value' => isset($model->educationLevel->level) ? $model->educationLevel->level : '-',
                'visible' => isset($model->educationLevel->level) ? true : false,
            ],
            [   
                'attribute' => 'Education field',
                'value' => isset($model->educationField->field) ? $model->educationField->field : '-',
                'visible' => isset($model->educationField->field) ? true : false,
            ],

            [   
                'attribute' => 'posting_date',
                'value' => $model->posting_date,
                'visible' => isset($model->posting_date) ? true : false,
            ],

             [   
                'attribute' => 'closure_date',
                'value' => $model->closure_date,
                'visible' => isset($model->closure_date) ? true : false,
            ],

            [   
                'attribute' => 'years_of_experience',
                'value' => $model->years_of_experience ,
                'visible' => $model->years_of_experience > 0 ? true : false,
            ],

            [   
                'attribute' => 'how_to_apply',
                'value' => $model->how_to_apply,
                'visible' => isset($model->how_to_apply) ? true : false,
                'format' => 'raw',
            ],

            [   
                'attribute' => 'contact_phone',
                'value' => $model->contact_phone,
                'visible' => isset($model->contact_phone) ? true : false,
            ],

            [   
                'attribute' => 'contact_email',
                'value' => $model->contact_email,
                'visible' => isset($model->contact_email) ? true : false,
            ],
 
            [   
                'attribute' => 'action_id',
                'value' => isset($model->actions->action) ? $model->actions->action : '-',
                'visible' => isset($model->actions->action) ? true : false,
            ], 
            [   
                'attribute' => 'district_id',
                'value' => $model->districts->district,
                'visible' => isset($model->districts->district) ? true : false,
            ],

            [   
                'attribute' => 'created_at',
                'value' => $model->created_at,
                'visible' => isset($model->created_at) ? true : false,
            ],
        ],
    ]) 
?>               

<?php
    // echo '<div class="row">';
    //     echo '<div class="col col-md-4">';
            
    //     echo '</div>';
    //     echo '<div class="col col-md-8">';
            
    //     echo '</div>';
    // echo '</div>';
    // if (isset($model->employerlogo_path)) echo Html::img($model->employerlogo_base_url . '/' . $model->employerlogo_path) . "<br>";
    // if (isset($model->employer)) echo "<b>Employer </b><br>" . $model->employer . "</b><br>";
    // if(isset($model->createdBy->employerProfile->emplEmployerSummaries->professional_profile)) echo $model->createdBy->employerProfile->emplEmployerSummaries->professional_profile;
    // if(isset($model->jobtitle)) echo "<br><b>Job title</b><br>" . $model->jobtitle . "<br>";
    // if(isset($model->jobType->job_type)) echo "<br><b>Job type </b><br>" . $model->jobType->job_type;
    // if(isset($model->job_summary)) echo "<br><b>Job summary </b><br>" . $model->job_summary . "<br>";
    // if(isset($model->economicSector->occupation)) echo "<br><b>Occupation</b><br>" . $model->economicSector->occupation;
    // if(isset($model->job_responsability)) echo "<br><b>Responsabilities</b><br>" . $model->job_responsability . "<br>";
    // if(isset($model->positions_number)) echo "<b>Number of position: </b>" . $model->positions_number;
    // if(isset($model->job_skill_requirement)) echo "<b>Requirement: </b>" . $model->job_skill_requirement. "<br>";
    // if(isset($model->job_remuneration)) echo "<b>Renumeration: </b>" . $model->job_remuneration;
    // if(isset($model->educationLevel->level)) echo "<b>Minimum education level: </b>" . $model->educationLevel->level;
    // if(isset($model->educationField->field)) echo "<b>Education field: </b>" . $model->educationField->field;
    // echo '<div class="row">';
    //     echo '<div class="col col-md-6">';
    //         if (isset($model->posting_date)) echo "<br><b>Posted date</b><br>" . $model->posting_date . "<br>";
    //     echo '</div>';
    //     echo '<div class="col col-md-6">';
    //         if (isset($model->closure_date)) echo "<br><b>Deadline date</b><br>" . $model->closure_date . "<br>";
    //     echo '</div>';
    // echo '</div>';
    // if($model->years_of_experience!=0) echo "<br><b>Years of experience: </b>" . $model->years_of_experience . "<br>"; else echo "<br><b>Years of experience: </b> None<br>";
    // if(isset($model->how_to_apply))echo "<br><b>How to apply</b><br>" . $model->how_to_apply . "<br>";
    // echo '<div class="row">';
    //     echo '<div class="col col-md-4">';
    //         if (isset($model->contact_phone)) echo "<br><b>Phone number</b><br>" . $model->contact_phone . "<br>";
    //     echo '</div>';
    //     echo '<div class="col col-md-8">';
    //         if (isset($model->contact_email)) echo "<br><b>Email</b><br>" . $model->contact_email . "<br>";
    //     echo '</div>';
    // echo '</div>';
    // if (isset($model->districts->district)) echo "<br><b>District</b><br>" . $model->districts->district . "<br><br>";
    // if(isset($model->link)) echo Html::a("More details, click here", Url::to($model->link), ["target" => "_blank", "class" => "btn btn-primary"])
    // if(isset($model->actions->action)) echo $model->actions->action;
    // if(isset($model->created_at)) echo "Created at: " . $model->created_at . "<br>";
?>