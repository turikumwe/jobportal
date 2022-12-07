<?php

use yii\helpers\Html;
use common\models\User;
use kartik\grid\GridView;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Curriculum Vitae';//$this->title;

$jobseeker = User::findOne($model->user_id);
?>
<div class="container" style="margin-top: 65px">
    <div class='row' style='text-align: center'><h3><u>Curriculum Vitae</u></h3></div>
    <div class="row">
        <div id="language" class="content-list content-menu responsive">
               
            
            <table class="">
                <tr style="background-color: #FFFFFF"><th colspan="5"><h5><b>I.PERSONAL INFORMATION</b></h5><br> </th></tr> 
                    <tr>
                       <td>
                        <b>Name:</b>
                        <?= $jobseeker->userProfile->fullName?>
                       </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Address:</b>
                            <?= common\models\JsAddress::currentAddress()?>      
                        </td>               
                    </tr> 
                    <tr>
                        <td>
                            <b>PhoneNumber:</b>
                            <?= $jobseeker->phone;?>    
                        </td>  
                    </tr>
                    <tr>
                        <td>
                            <b>Email Address:</b>
                            <?= $jobseeker->email?>      
                        </td>               
                    </tr> 
            </table>

            <hr>
            
            
            <table class='table table-bordered'> 
                <tr style="background-color: #F1F5F8"><th colspan="6"> <h5><b>II. EDUCATION</b></h5></th></tr> 
                <tr>
                    <th colspan="2"><center>Date</center></th>
                    <th>School</th>
                    <th>Address</th>
                    <th>Education Field</th>
                    <th>Certificate</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
                <?php
                $educations = $jobseeker->jsEducations;                        
                foreach($educations as $education){ ?>

                <tr>
                    <td><?= date('m/Y' , strtotime($education->start_date));?></td>
                    <td><?= date('m/Y' , strtotime($education->end_date));?></td>
                    <td><?= $education->school;?></td>
                    <td><?= isset($education->educationField->field) ? '-' : "-" ;?></td>
                    <td><?= isset($education->educationField->field) ? $education->educationField->field : "-" ;?></td>
                    <td><?= isset($education->certificate->certificate) ? $education->certificate->certificate : "-";?></td>  
                </tr>

            <?php } ?>

            </table>

            <hr>

            
            <table class='table table-bordered'> 
            <tr class='thcolor' style="background-color: #F1F5F8"><th colspan="4"> <h5><b>III. OTHER TRAINING/AWARD</b></h5> </th></tr> 
            <tr>
                    <th colspan="2"><center>Date</center></th>
                    <th>Training center</th>
                    <th>Training title</th>
                    
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>         
               
                <?php
                    $trainings = $jobseeker->jsTrainings;                          
                    foreach($trainings as $training){
                ?>
                    <tr>
                        <td><?= date('d/m/Y' , strtotime($training->start_date));?></td>
                        <td><?= date('d/m/Y' , strtotime($training->end_date));?></td>
                        <td><?= $training->training_center;?></td>
                        <td><?= $training->training_title;?></td>               
                    </tr> 
                <?php  } ?>
            </table>

            <hr>

            
            <table class='table table-bordered'> 
                <tr style="background-color: #F1F5F8"><th colspan="5"> <h5><b>IV. LANGUAGE</b></h5> </th></tr>       
                <tr>
                    <th>Language</th>
                    <th>Reading</th>
                    <th>Writing</th>
                    <th>Listening</th>
                    <th>Speaking</th>
                </tr>
                <?php
                    $languages = $jobseeker->jsLanguages;                          
                    foreach($languages as $language){
                ?>
                    <tr>
                       <td><?= isset($language->language0->language) ? $language->language0->language : "-" ;?></td>
                       <td><?= isset($language->reading0->languagerate) ? $language->reading0->languagerate : "-" ;?></td>               
                       <td><?= isset($language->writing0->languagerate) ? $language->writing0->languagerate : "-";?></td>
                       <td><?= isset($language->listening0->languagerate) ? $language->listening0->languagerate : "-";?></td>
                       <td><?= isset($language->speaking0->languagerate) ? $language->speaking0->languagerate : "-";?></td>
                    </tr>  
                <?php } ?>
            </table>

            <hr>

            
            <table class='table table-bordered'>
                <tr style="background-color: #F1F5F8"><th colspan="2"> <h5><b>V. SKILLS</b></h5> </th></tr>  
                <tr>
                    <th>Skills</th>
                    <th>Skills level</th>
                </tr>
                <?php
                    $skills = $jobseeker->jsSkills;                        
                    foreach($skills as $skill){
                ?>
                    <tr>
                       <td><?= isset($skill->skill->skill) ? $skill->skill->skill: "-";?></td>
                       <td><?= isset($skill->skillLevel->level) ? $skill->skillLevel->level: "-";?></td>
                    </tr> 
                <?php  } ?>
            </table>

            <hr>

            <table class='table table-bordered'> 
                <tr style="background-color: #F1F5F8">
                    <th colspan="4"> <h5><b>VI. Professional Experience </b></h5> </th>
                </tr>
                <tr>
                    <th>StartDate</th>
                    <th>EndDate</th>
                    <th>Employer</th>
                    <th>Occupation</th>
                    <th>Position</th>
                </tr>
                <?php
                    $experiences = $jobseeker->jsExperiences;                          
                    foreach($experiences as $experience){
                        if(count($experiences) != 0) {
                ?>
                    <tr>
                       <td><?= $experience->start_date?></td>
                       <td><?= $experience->end_date?></td>
                       <td><?= isset($experience->company) ? $experience->company : "-" ?></td>
                       <td><?= isset($experience->occupation->occupation) ? $experience->occupation->occupation: "-" ?></td>
                       <td><?= $experience->exact_position;?></td>
                    </tr> 
                <?php  }  else { ?>
                    <tr colspan="4"><td>No found</td></tr>
                <?php } }  ?>
            </table>
        
        </div>
    </div>
</div>
