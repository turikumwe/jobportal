<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = "Employment Service Centres";
// $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-3 clpadding"><br>
        <div id="displayAll" class="panel widget light-widget panel-bd-top">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse11" class="blue-heading">
                    Kigali <br>Employment Service Centre
                </a>
            </div>
            <div class="panel-body tags" id="district" style="display:block">
                <table class="table table-condensed" style="padding-leflt: 0px;">
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                <div class="side-link">Employers</div>
                            </a>
                        </td>
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                <div class="side-link"> Job seekers</div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                <div class="side-link">Contact information</div>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="displayAll" class="panel widget light-widget panel-bd-top">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse12" class="blue-heading">
                    Musanze <br>Employment Service Centre
                </a>
            </div>
            <div class="panel-body tags" id="district" style="display:block">
                <table class="table table-condensed">
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                <div class="side-link">Employers</div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                                <div class="side-link">Job seekers</div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                                <div class="side-link">Contact information</div>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="displayAll" class="panel widget light-widget panel-bd-top">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse13" class="blue-heading">
                    Huye <br>Employment Service Centre
                </a>
            </div>
            <div class="panel-body tags" id="district" style="display:block">
                <table class="table table-condensed">
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
                                <div class="side-link">Employers</div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
                                <div class="side-link">Job seekers</div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse9">
                                <div class="side-link">Contact information</div>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default noborder">
                <div id="collapse10" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="tabs">
                                <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 8px;">
                                    <li>&nbsp;</li>
                                    <li style="border-right: 0px">Employment Service Centres</li>
                                </ul>
                            </div>
                            <div class="col col-md-12" style="padding-left: 0px;">
                                Employment Service Centres are a crucial instrument in organizing a
                                transparent and functioning labour marketplace and enabling the demand
                                of labour to meet its supply. <br><br>
                                The Government of Rwanda has designed policies and employed a
                                considerable effort to combat the issue of unemployment through the
                                establishment of Employment Service Centres in Kigali (KESC), Musanze
                                (MESC) and in Huye districts (HESC). <br><br>
                                The centers have the mandate of addressing unemployment and
                                underemployment by linking jobseekers and job providers.<br><br>
                                They also provide information for decision making in career planning,
                                training on job search strategy and other counselling support that
                                could result into job placement.<br><br>
                                Besides Public Employment Service Centers, there are a number of
                                private employment service providers in Rwanda, who do offer employment
                                services as well. They also strongly support the matching of jobseekers
                                with potential employers by connecting them to temporary or permanent
                                employment and internship opportunities in the labour market.<br><br>
                                You will find more information about the existing Public Employment
                                Service Centers and their services on the left side of this page.<br><br>

                                Some of the private companies, who do offer matching online services
                                and recruitment services in Rwanda include:<br><br>
                                <?= Html::a("Job in Rwanda", 'https://www.jobinrwanda.com', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); ?><br>
                                <?= Html::a("NFT Consult", 'https://www.nftconsult.com', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); ?><br>
                                <?= Html::a("Right Seat", 'https://www.rightseat.rw', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); ?><br>
                                <?= Html::a("Umurimo", 'https://www.umurimo.com', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); ?><br><br>
                                <strong>
                                    NOTE: RDB is not responsible for the content of the mentioned
                                    companies’ websites. This list of matching and recruitment service
                                    providers might not be complete.
                                </strong>
                            </div>
                            <!-- <div class="col-md-3" style="padding: 10px;">
                        <b>Links</b><br>

                        <p>Offer matching online</p>
                        <?php //echo Html::a("Job in Rwanda",'https://www.jobinrwanda.com', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br>
                        <?php //echo  Html::a("NFT Consult",'https://www.nftconsult.com', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br>
                        <?php //echo  Html::a("Right Seat",'https://www.rightseat.rw', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br>
                        <?php //echo  Html::a("Umurimo",'https://www.umurimo.com', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br><br>

                        <p>Prepare job seekers</p>
                        <?php //echo  Html::a("Akazi Kanoze Access",'https://www.akazikanoze.org', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br>
                        <?php //echo  Html::a("Bag Innovation",'https://www.baginnovation.rw', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br>
                        <?php //echo  Html::a("Bridge2Rwanda",'https://www.bridge2rwanda.org', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br>
                        <?php //echo  Html::a("Bright Future Cornerstone",'https://www.brightfuturelines.net', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br>
                        <?php //echo  Html::a("Dot. Rwanda",'https://www.rwanda.dotrust.org', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br>
                        <?php //echo  Html::a("Harambe",'https://www.harambee.co.za', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br>
                        <?php //echo  Html::a("Resonate",'https://www.resonateworkshops.org', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']); 
                        ?><br>
                    </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse11" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Kigali Employment Service Centre</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col col-md-9">
                                Launched in 2013, Kigali Employment Service Centre (KESC) was
                                the first Public Employment Service Centre initiated by MIFOTRA
                                and the City of Kigali.<br><br>
                                Today, the Centre is fully operated by the City of Kigali and
                                works in close cooperation with RDB, which is the coordinating
                                institution for employment services in the country.<br><br>
                                KESC is located in the heart of Kigali City, next to the YEGO
                                Centre (Youth Empowerment for Global Opportunities Centre) in
                                Kimisagara.<br><br>

                                For more information, please contact: <br>Aloys Niyonsaba, <br>Centre Manager,<br>
                                Mobile: 0788894495.<br>
                            </div>
                            <div class="col col-md-3" style="text-align: center"><br>
                                <a href="http://www.kigalicity.gov.rw/index.php?id=5" target="_blank">
                                    <b>Kigali city</b><br>
                                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/kcitylogo.png"); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs widget">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Kigali Employment Service Centre</li>
                            </ul>
                        </div>
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

                        KESC team is looking forward to discuss with you tailor made solutions for your labor needs.<br><br>

                        For further information please contact:<br>
                        Kyatuka Geoffry, Placement Officer <br>
                        Tel: 0788 - 280832<br>
                        Bucyana Alex, Placement Officer<br>
                        Tel: 0788 - 594983<br><br>
                        KESC is located in the heart of Kigali City, jointly with the YEGO Centre
                        (Youth Empowerment for Global Opportunities Center) in Kimisagara, Nyarugenge
                        District.
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs widget">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Kigali Employment Service Centre</li>
                            </ul>
                        </div>
                        Dear jobseeker,<br><br>
                        Finding the right job that offers you good career prospects can be difficult.
                        Moreover, various skill-sets are required and intensive preparation is needed.
                        Kigali Employment Service Center assists you to design your career and explore
                        employment opportunities.<br><br>
                        <div class="row">
                            <div class="col-md-6">
                                <b>We have the following free services for jobseekers:</b>
                                <ul>
                                    <li>Access to job opportunities, training and internship from
                                        private, public, national and international institution</li>
                                    <li>Profiling jobseekers in a database to fill available
                                        vacancies</li>
                                    <li>Supporting jobseekers to identify technical and social skills
                                        in order to increase chance on labor market</li>
                                    <li>Support jobseekers to identify aspects of personality and
                                        motivation that are crucial for jobseeker’s profile</li>
                                    <li>Assistance from well-trained career and employment
                                        counselors</li>
                                    <li>Internet access to get employment related information, e.g.
                                        jobs, career option, self-employment, internship and
                                        trainings</li>
                                    <li>Preparation for the job application</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <?= Html::img(Yii::getAlias('@storageUrl') . '/source/1/jobseekerkesc.png', ['alt' => 'KESC']) ?>
                            </div>
                        </div><br>

                        <b>Furthermore we offer different trainings to jobseekers:</b><br>
                        <ul>
                            <li>IT-skills (Word, Excel, Outlook, Internet search)</li>
                            <li>Job search strategy (self-awareness, self-marketing)</li>
                            <li>Training on entrepreneurship (training on business plan and coaching
                                to start your business)</li>
                            <li>English training (basic and advanced)</li>
                            <li>Opportunity scouting (training on self-awareness/career planning and
                                exploration the labor and education market opportunities)</li>
                            <li>Cooperate social responsibility sessions (different companies share
                                information about their work field and environment)</li>
                            <li>Women focus group discussion (women related topics and role models for
                                success stories)</li>
                            <li>Career coaching courses at TVET schools</li>
                        </ul>

                        We are looking forward to your visit at our center in Kimisagara, KESC team
                        will be happy to assist you with your career planning and prepare the path to
                        success.<br>

                        For more information please contact:<br>
                        Umutoni Aline, <br>
                        Employment Counsellor<br>
                        Tel: 0788-420484
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs widget">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Kigali Employment Service Centre</li>
                            </ul>
                        </div>
                        <b>FOR MORE INFORMATION, PLEASE CONTACT KESC:</b><br>
                        Niyonsaba Aloys, <br>
                        KESC Manager, <br>
                        Email: aniyonsaba@kigalicity.gov.rw<br>
                        Phone: 0788-354495<br>
                        <b>Center Social media: </b>
                        <?= Html::a(Html::img(Yii::getAlias('@storageUrl') . "/source/1/facebook.png", ['width' => '30px']), 'https://web.facebook.com/KigaliEmploymentServiceCentre', ['target' => '_blank']); ?>
                        <?= Html::a(Html::img(Yii::getAlias('@storageUrl') . "/source/1/twitter.png", ['width' => '30px']), 'https://twitter.com/Employmentcentr', ['target' => '_blank']); ?>
                        <br>
                        <!-- <span style="color: red">DOWNLOAD LINK TO FACTSHEETS (attached to this email)</span> -->
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse12" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Musanze Employment Service Centre</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col col-md-9">
                                Musanze Employment Service Centre (MESC) was initiated by MIFOTRA and the
                                District of Musanze and was launched in 2016. <br><br>
                                Today, the centre is mainly operated by Musanze District and works
                                in close cooperation with RDB, which is the coordinating institution
                                for employment services in the country.<br><br>
                                MESC is located in the heart of Musanze City, next to the YEGO Centre
                                (Youth Empowerment for Global Opportunities Centre) and close to the
                                BDF Musanze Branch.<br><br>

                                For more information, please contact: <br>Aimable Rwigamba, <br>Centre Manager,<br>
                                Mobile: 0788407519

                            </div>
                            <div class="col col-md-3" style="text-align: center"><br>
                                <a href="https://musanze.gov.rw/index.php?id=39" target="_blank">
                                    <b>Musanze district</b><br>
                                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/rwandalogo.png"); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse4" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs widget">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Musanze Employment Service Centre</li>
                            </ul>
                        </div>
                        Dear employers,<br><br>
                        Finding the right candidate for a position in your company can cost a lot of
                        time and money. With MESC you have a strong partner who can help you
                        throughout the entire process.<br><br>

                        <b>We offer the following services for free:</b><br>

                        <ul>
                            <li>Connect employers and jobseekers by evaluating employers’ needs and
                                jobseekers’ capacities, organizing job fairs and connecting jobseekers to
                                professional internships, mentorship and industrial attachments.</li>
                            <li>Provide a database and space where employers can post available job
                                vacancies at no cost.</li>
                            <li>Evaluate the MESC jobseekers’ database to identify qualified
                                candidates for job vacancies</li>
                            <li>Identify aspects of personality and motivation that are crucial to a
                                jobseeker’s profile</li>
                            <li>Preparing jobseekers to start new jobs</li>
                        </ul>

                        In line with our vision, it is our duty to prepare selected candidates before
                        starting a job. Together with the jobseekers we carefully analyze their
                        profiles and explore job opportunities they can fit in. We strengthen their
                        communication and work readiness skills through individual coaching,
                        organizing specific trainings and arranging internships. At the end of the day,
                        we know who to recommend.<br><br>

                        MESC team is looking forward to discuss with you tailor made solutions for your labour needs.<br><br>

                        For further information please contact: <br>
                        Aimable Rwigamba, <br>
                        MESC Manager<br>
                        Tel: 0788-40-7519<br><br>
                        MESC is located in the heart of Musanze City, jointly with the YEGO Centre
                        (Youth Empowerment for Global Opportunities Center) and close to the BDF
                        Musanze Branch.
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse5" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs widget">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Musanze Employment Service Centre</li>
                            </ul>
                        </div>
                        Dear jobseeker,<br><br>

                        Finding the right job that offers you good career prospects can be difficult.
                        Moreover, various skill-sets are required and intensive preparation is needed.
                        Musanze Employment Service Center assists you to design your career and explore
                        employment opportunities.<br><br>

                        <div class="row">
                            <div class="col-md-6">
                                <b>We have the following free services for job seekers: </b>

                                <ul>
                                    <li>Registering jobseekers and maintaining an updated database of
                                        their CVs</li>
                                    <li>Providing information on job, internship and training
                                        opportunities</li>
                                    <li>Support jobseekers to improve on their job readiness skills</li>
                                    <li>Reaching out and liaising with potential employers for job
                                        matching and internship opportunities</li>
                                    <li>Offer secretarial facilities (typing, printing, and copying
                                        facilities) after orientation to the functions offered by the
                                        centre</li>
                                    <li>Conduct brief sessions for career guidance and support in
                                        application procedures (cover letter and CV writing, interview
                                        preparations etc.)</li>
                                    Organising trainings and individual coaching on specific skills
                                    (e.g. ICT skills, English skills, communication skills)</li>
                                </ul>
                            </div>
                            <div class="col-md-6" style="text-align: center">
                                <?= Html::img(Yii::getAlias('@storageUrl') . '/source/1/jobseekermesc.png', ['alt' => 'KESC', 'height' => '270px']) ?>
                            </div>
                        </div><br>

                        We are looking forward to your visit at our center, MESC team will be happy to
                        assist you with your career planning and prepare the path to success.<br><br>
                        MESC is located in the heart of Musanze City, jointly with the YEGO Centre
                        (Youth Empowerment for Global Opportunities Center) and close to the BDF
                        Musanze Branch.<br><br>

                        If you would like to have more information on phone, please contact: <br>
                        Aimable Rwigamba,<br>
                        MESC Manager,<br>
                        Tel: 0788-40-7519
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse6" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs widget">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Musanze Employment Service Centre</li>
                            </ul>
                        </div>
                        <b>FOR MORE INFORMATION, PLEASE CONTACT MESC:</b><br>
                        Aimable Rwigamba, <br>
                        MESC Manager,<br>
                        Email: info.mesc@musanze.gov.rw ,<br>
                        Phone: 0788-40-7519<br>
                        Centre Social media:
                        <?= Html::a(Html::img(Yii::getAlias('@storageUrl') . "/source/1/facebook.png", ['width' => '30px']), 'https://web.facebook.com/MusanzeEmploymentServiceCentre', ['target' => '_blank']); ?>
                        <?= Html::a(Html::img(Yii::getAlias('@storageUrl') . "/source/1/twitter.png", ['width' => '30px']), 'https://twitter.com/MUSANZE_ESC', ['target' => '_blank']); ?>
                        <br>

                        <!-- <span style="color: red">DOWNLOAD LINK TO FACTSHEETS (attached to this email)</span> -->
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse13" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Huye Employment Service Centre</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col col-md-9">
                                Huye Employment Service Centre (HESC) was initiated by RDB and
                                the District of Huye in 2019.<br><br>
                                Currently in its initial stage, the centre is mainly operated
                                by Huye District with support from RDB, which is the
                                coordinating institution for employment services in the
                                country.<br><br>
                                HESC is centrally located near the bus park in the City of
                                Huye.<br><br>

                                For more information please contact:
                                <br>Chantal Mukama,
                                <br>Centre Manager,
                                <br>Mobile: 0788354859

                            </div>
                            <div class="col col-md-3" style="text-align: center"><br>
                                <a href="http://www.huye.gov.rw/index.php?id=39" target="_blank">
                                    <b>Huye district</b><br>
                                    <?= Html::img(Yii::getAlias('@storageUrl') . "/source/1/rwandalogo.png"); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse7" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs widget">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Huye Employment Service Centre</li>
                            </ul>
                        </div>
                        Dear employers,<br><br>
                        Finding the right candidate for a position in your company can cost a lot of
                        time and money. With HESC, you have a strong partner who helps you throughout
                        this process.
                        <br><br>
                        <b>We offer the following services for free:</b><br>
                        <ul>
                            <li>Collect information about local skills needs for employers</li>
                            <li>Provide guidance to employers in the labour market</li>
                            <li>Improve employability of labor through knowledge sharing of current
                                opportunities</li>
                            <li>Providefree recruitment services upon request (vacancy posting,
                                pre-selection of candidates for jobs, internships or training,
                                conducting interviews)</li>
                        </ul>

                        In line with our vision, it is our duty to adequately prepare selected
                        candidates before starting a job. Together with the job seekers, we carefully
                        analyse their profiles and match them to available job opportunities.
                        We strengthen their communication and work readiness skills through
                        individual coaching, organising specific trainings and arranging internships.
                        We know who to recommend to deliver quality services to the satisfaction of
                        employers.<br><br>

                        HESC team is looking forward to discussing with you tailor made solutions for
                        your labor needs. For further information please contact: to be communicated
                        asap <br><br>
                        If you wish to visit us personally, HESC is located near the bus station in
                        Huye District.<br><br>
                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse8" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs widget">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Huye Employment Service Centre</li>
                            </ul>
                        </div>
                        Dear jobseeker,<br><br>
                        Finding the right job that offers you good career prospects can be difficult.
                        Moreover, various skill-sets are required and intensive preparation is needed.
                        Huye Employment Service Center assists you to design your career and explore
                        employment opportunities.
                        <br><br>

                        <div class="row">
                            <div class="col-md-12">
                                <b>We have the following free services for job seekers:</b>

                                <ul>
                                    <li>Registering jobseekers and maintaining an updated database of
                                        their CVs</li>
                                    <li>Providing information on job, internship and training
                                        opportunities</li>
                                    <li>Support jobseekers to improve on their job readiness skills</li>
                                    <li>Reaching out and liaising with potential employers for job
                                        matching and internship opportunities</li>
                                    <li>Offer secretarial facilities (typing, printing, and copying
                                        facilities) after orientation to the functions offered by the
                                        centre</li>
                                    <li>Conduct brief sessions for career guidance and support in
                                        application procedures (cover letter and CV writing, interview
                                        preparations etc.)</li>
                                    <li>Organising trainings and individual coaching on specific
                                        skills (e.g. ICT skills, English skills, communication skills)</li>
                                </ul>
                            </div>
                            <!-- <div class="col-md-6" style="text-align: center"> -->
                            <?php //echo Html::img( Yii::getAlias('@storageUrl') . '/source/1/jobseekerhesc.png',['alt' => 'HESC', 'height' => '270px']) 
                            ?>
                            <!-- </div> -->
                        </div>

                        We are looking forward to your visit at our center, HESC team will be happy to
                        assist you with your career planning and prepare the path to success.<br><br>
                        If you would like to have more information on phone, please contact:<br>

                        UWINEZA Chantal, <br>
                        HESC Manager, <br>
                        Email: info.hesc@huye.gov.rw<br>
                        Phone: 0788354859<br>

                    </div>
                </div>
            </div>
            <div class="panel panel-default noborder">
                <div id="collapse9" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="tabs widget">
                            <ul class="nav nav-tabs widget" style="color: #fff; margin-top: 2px;">
                                <li>&nbsp;</li>
                                <li style="border-right: 0px">Huye Employment Service Centre</li>
                            </ul>
                        </div><br>
                        <b>FOR MORE INFORMATION, PLEASE CONTACT HESC:</b><br>
                        UWINEZA Chantal, <br>
                        HESC Manager, <br>
                        Email: info.hesc@huye.gov.rw<br>
                        Phone: 0788354859<br>
                        <?= Html::a(Html::img(Yii::getAlias('@storageUrl') . "/source/1/facebook.png", ['width' => '30px']), 'https://www.facebook.com/CenterHuye/?modal=admin_todo_tour', ['target' => '_blank']); ?>
                        <?= Html::a(Html::img(Yii::getAlias('@storageUrl') . "/source/1/twitter.png", ['width' => '30px']), 'https://twitter.com/CenterHuye', ['target' => '_blank']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- <div class="container"><br>
    <div class="tab-content">
        <?php //echo $model->body; 
        ?>

        <div class="row" style="position: relative;margin-top: 5%;margin-bottom: 5%;">
            <div class="col-md-1">
                &nbsp;
            </div>
            <div class="col-md-3">
                <div class="flex-popular">
                    <?= Html::a('Kigali ESC', ['site/kesc'], ['style' => 'color: #ffffff']) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="flex-popular">
                    <?= Html::a('Musance ESC', ['site/mesc'], ['style' => 'color: #ffffff']) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="flex-popular">
                    <?= Html::a('Huye ESC', ['site/hesc'], ['style' => 'color: #ffffff']) ?>
                </div>
            </div>
            <div class="col-md-1">
                &nbsp;
            </div>
        </div>
    </div>
</div> -->