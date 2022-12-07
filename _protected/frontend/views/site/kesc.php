<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
$this->title = "KESC";
// $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;

?>
<div class="container">
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
                    Finding the right candidate for a position in your company can cost a lot of time and 
                    money. In KESC you have a strong partner who can help you throughout this process.<br><br>

                    <b>We offer the following services for free:</b><br>
                    <ul>
                        <li>Connect employers and jobseekers by evaluating employers’ needs and jobseekers’ 
                        capacities, organizing job fairs and connecting jobseekers to professional 
                        internships, mentorship and industrial attachments.</li>
                        <li>Provide a database and space where employers can post available job vacancies 
                        at no cost.</li>
                        <li>Evaluate the KESC jobseekers’ database to identify qualified candidates for job 
                        vacancies</li>
                        <li>Identify aspects of personality and motivation that are crucial to a jobseeker’s 
                        profile</li>
                        <li>Preparing jobseekers to start new jobs</li>
                    </ul>

                    In line with our vision, it is our duty to prepare selected candidates before starting 
                    a job. Together with the jobseekers we carefully analyze their profiles and explore 
                    job opportunities they can fit in. We strengthen their communication and work readiness 
                    skills through individual coaching, organizing specific trainings and arranging 
                    internships. At the end of the day, we know who to recommend.<br><br>

                    KESC team is looking forward to discuss with you tailor made solutions for your labor needs.<br>
                    
                    For further information please contact:<br>
                    Kyatuka Geoffry, Placement Officer <br>
                    Tel: 0788 - 280832<br>
                    Bucyana Alex, Placement Officer<br>
                    Tel: 0788 - 594983<br>
                    KESC is located in the heart of Kigali City, jointly with the YEGO Centre 
                    (Youth Empowerment for Global Opportunities Center) in Kimisagara, Nyarugenge 
                    District.
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
                    finding the right job that offers you good career prospects can be difficult. 
                    Moreover, various skill-sets are required and intensive preparation is needed. 
                    Kigali Employment Service Center assists you to design your career and explore 
                    employment opportunities.<br><br>
                    <div class="row">
                        <div class="col-md-6">
                            <b>We have the following free services for jobseekers:</b>
                            <ul>
                                <li>Access to job opportunities, training and internship from private, public, 
                                    national and international institution</li>
                                <li>Profiling jobseekers in a database to fill available vacancies</li>
                                <li>Supporting jobseekers to identify technical and social skills in order to 
                                    increase chance on labor market</li>
                                <li>Support jobseekers to identify aspects of personality and motivation that 
                                    are crucial for jobseeker’s profile</li>
                                <li>Assistance from well-trained career and employment counselors</li>
                                <li>Internet access to get employment related information, e.g. jobs, career 
                                    option, self-employment, internship and trainings</li>
                                <li>Preparation for the job application</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <?= Html::img( Yii::getAlias('@storageUrl') . '/source/1/jobseekerkesc.png',['alt' => 'KESC']) ?>
                        </div>
                    </div><br>

                    <b>Furthermore we offer different trainings to jobseekers:</b><br>
                    <ul>
                        <li>IT-skills (Word, Excel, Outlook, Internet search)</li>
                        <li>Job search strategy (self-awareness, self-marketing)</li>
                        <li>Training on entrepreneurship (training on business plan and coaching to start 
                            your business)</li>
                        <li>English training (basic and advanced)</li>
                        <li>Opportunity scouting (training on self-awareness/career planning and exploration 
                            the labor and education market opportunities).</li>
                        <li>Cooperate social responsibility sessions (different companies share information 
                            about their work field and environment)</li>
                        <li>Women focus group discussion (women related topics and role models for success 
                            stories)</li>
                        <li>Career coaching courses at TVET schools</li>
                    </ul>

                    We are looking forward to your visit at our center in Kimisagara, KESC team will be 
                    happy to assist you with your career planning and prepare the path to success.<br>
                    For more information please contact:<br>
                    Umutoni Aline, Employment Counsellor<br>
                    Tel: 0788-420484
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
                    <b>FOR MORE INFORMATION, PLEASE CONTACT KESC:</b><br>
                    Email: aniyonsaba@kigalicity.gov.rw<br>
                    Facebook: Kigali Employment Service Centre<br>
                    Twitter: Kigali Employment Service Center<br>
                    Phone: 0788-354495 (KESC Manager, Niyonsaba Aloys)<br>
                    <span style="color: red">DOWNLOAD LINK TO FACTSHEETS (attached to this email)</span>
                </div>
            </div>
        </div>
    </div>
</div>