<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
$this->title = "MESC";
// $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Html;
?>
<div class="container"><br>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                    Employers</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse in">
                <div class="panel-body">
                    Dear employers,<br><br>
                    finding the right candidate for a position in your company can cost a lot of time and money. With MESC you have a strong partner who helps you through this process. 
                    We are excited to offer you the following free services:<br>
                    <ul>
                        <li>Collect information about local skills needs from the employer’s perspective and 
                        contribute to minimizing mismatching</li>
                        <li>Provide guidance to employers on the labour market</li>
                        <li>Improve employability through knowledge of and access to the local workforce opportunities</li>
                        <li>Free recruitment services upon request (vacancy posting, pre-selection of candidates for 
                        jobs, internships or training, conducting interviews)</li>
                    </ul>

                    In line with our vision it is our duty to prepare selected candidates very well before starting 
                    a job. Together with the job seeker we carefully analyse their profiles and explore job 
                    opportunities. We strengthen their communication and work readiness skills through individual 
                    coaching, organising specific trainings and arranging internships. We know who we recommend.<br><br>

                    To deliver quality services to the satisfaction of our clients makes our daily work meaningful.<br><br>

                    <div class="alert alert-info" style="text-align: justify;font-weight: bolder">
                        “We have continually been taking the services of MESC to receive suitable candidates in our 
                        clinic and recently signed an MoU with the centre and our collaboration is growing. We are 
                        very satisfied with applicants who have applied through the centre. They are well prepared and 
                        committed to the job. We had our first intern Aline in May 2017 for six months who was very 
                        well prepared by the centre. She demonstrated strong skills that were an asset for our company. 
                        She is now our employee.  We now have a second intern, Zita, through MESC.” <br>
                        Dr. Eugene Rutayombya / Managing Director, Clinique Mpore Liberté <br>
                    </div>


                    MESC team is looking forward to discuss with you tailor made solutions, for further information 
                    please contact: <br>
                    Aimable Rwigamba, MESC Manager<br>
                    Tel: 0788-40-7519<br>
                    If you wish to visit us personally, MESC is located in the heart of Musanze City, 
                    jointly with the YEGO Centre (Youth Empowerment for Global Opportunities Center) and close 
                    to the BDF Musanze Branch.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                    Job seekers</a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                    Dear jobseeker,<br><br>
                    finding the right job that offers you good career prospects can be difficult. Moreover, 
                    various skill-sets are required and intensive preparation is needed. Musanze Employment 
                    Service Center assists you to design your career and explore employment opportunities.<br><br>

                    <div class="row">
                        <div class="col-md-6">
                            <b>We have the following free services for job seekers: </b>

                            <ul>
                                <li>Registering jobseekers and maintaining an updated database of their CVs</li>
                                <li>Providing information on job, internship and training opportunities</li>
                                <li>Support jobseekers to improve on their job readiness skills</li>
                                <li>Reaching out and liaising with potential employers for job matching and internship 
                                    opportunities</li>
                                <li>Offer secretarial facilities (typing, printing, and copying facilities) after orientation to 
                                    the functions offered by the centre </li>
                                <li>Conduct brief sessions for career guidance and support in application procedures 
                                    (cover letter and CV writing, interview preparations etc.)</li>
                                <li>Organising trainings and individual coaching on specific skills (e.g. ICT skills, 
                                    English skills, communication skills)</li>
                            </ul>
                        </div>
                        <div class="col-md-6" style="text-align: center">
                            <?= Html::img( Yii::getAlias('@storageUrl') . '/source/1/jobseekermesc.png',['alt' => 'KESC', 'height' => '270px']) ?>
                        </div>
                    </div><br>

                    We are looking forward to your visit at our center, MESC team will be happy to assist you with 
                    your career planning and prepare the path to success.<br>
                    MESC is located in the heart of Musanze City, jointly with the YEGO Centre (Youth Empowerment 
                    for Global Opportunities Center) and close to the BDF Musanze Branch.<br>
                    If you would like to have more information on phone, please contact: 0788-40-7519 
                    (MESC Manager, Aimable Rwigamba)
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                    Contact information</a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <b>FOR MORE INFORMATION, PLEASE CONTACT MESC:</b><br>
                    Email: info.mesc@musanze.gov.rw<br>
                    Facebook: Musanze Employment Service Centre<br>
                    Twitter: @MUSANZE_ESC<br>
                    Phone: 0788-40-7519 (MESC Manager, Aimable Rwigamba)<br>
                    <span style="color: red">DOWNLOAD LINK TO FACTSHEETS (attached to this email)</span>
                </div>
            </div>
        </div>
    </div>
</div>