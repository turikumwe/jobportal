<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
$this->title = "Career Guidance";
// $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;

?>

<div class="container">
    <div class="row">
        <div class="col-md-3 clpadding">
            <div id="displayAll" class="panel widget light-widget panel-bd-top">
                <div class="panel-heading">
                    <a href="#" class="blue-heading">
                        Planning my career
                    </a>
                </div>
                <div class="panel-body tags" id="district" style="display:block">
                    <table class="table table-condensed">
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                    <div class="side-link">Know yourself</div>
                                </a>
                            </td>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                    <div class="side-link">Collecting information about professions</div>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div id="displayAll" class="panel widget light-widget panel-bd-top">
                <div class="panel-heading">
                    <a href="#" class="blue-heading">
                        Job video clips
                    </a>
                </div>
                <div class="panel-body tags" id="district" style="display:block">
                    <table class="table table-condensed">
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                    <div class="side-link">Do you like to organise things?</div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                    <div class="side-link">Do you like playing with maths?</div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                                    <div class="side-link">Do you like to work with computers?</div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                                    <div class="side-link">Do you like to create things?</div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
                                    <div class="side-link">Do you like to work with your hands?</div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
                                    <div class="side-link">Do you like to be outside?</div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse9">
                                    <div class="side-link">Do you like to work in the nature?</div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse10">
                                    <div class="side-link">Do you like to work at night?</div>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tabs widget">
                <ul class="nav nav-tabs widget" style="color: #fff;">
                    <li>&nbsp;</li>
                    <li style="border-right: 0px">Career guidance</li>
                </ul>
            </div>
            <!-- <h3>Planning my career</h3> -->

            <div class="panel-group" id="accordion">
                <div class="panel panel-primary noborder">
                    <!-- <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                Knowing about yourself</a>
            </h4>
        </div> -->
                    <div id="collapse1" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <h3>Knowing yourself</h3><br>
                                    Self-assessment is a big topic. It's the one that you probably think
                                    you can skip but it is the heart and soul of the job search process
                                    for serious job seekers.<br><br>
                                    Before you begin the actual job search process, it is important to
                                    think about your goals, abilities, interests and values.<br><br>
                                    This will help you market yourself more effectively and demonstrate
                                    why you should be hired.<br><br>
                                    Therefore, before beginning your job search, you should be able to
                                    answer these questions:<br>
                                    <ul>
                                        <li>What are your abilities?</li>
                                        <li>Your strengths?</li>
                                        <li>What type of work are you interested in?</li>
                                        <li>What type of organization(s)/ company(ies) do you want to
                                            work for?</li>
                                        <li>What skills have you developed through your education,
                                            work experience or activities?</li>
                                    </ul>
                                    You can find answers by taking a close look at yourself.<br><br>
                                    In order to help you to know more about yourself, your interests and
                                    talents, there are some tools you can use for free. The following are
                                    some examples but there are more online.
                                </div>
                                <div class="col-md-3" style="padding: 10px; background-color: #f5f5f5">
                                    <b>Links</b><br><br>
                                    <?= Html::a('Knowing your personality', 'https://www.123test.com/jung-personality-test/', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']) ?><br>

                                    <?= Html::a('Entrepreneur Quiz', 'http://www.humanmetrics.com/entrepreneur', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']) ?> <br>

                                    <?= Html::a('Page with links to different test', 'https://www.monster.com/career-advice/article/best...', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']) ?>

                                    <?php //echo Html::a('Self descriptive words', ['/storage/howtoapply/SELFDESCRIPTIVEWORDS.pdf'],['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;'])
                                    ?><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary noborder">
                    <!-- <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                Collecting information about professions</a>
            </h4>
        </div> -->
                    <div id="collapse2" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Collecting information about professions</h3><br>
                                    It is very important to make well informed decisions! If you are looking for
                                    orientation in order to choose the right profession, you should adequately inform
                                    yourself about the professions you are interested in.<br><br>

                                    In addition, there is a lot of information available online. However,
                                    keep in mind that this information always depends on the specific
                                    circumstances in the respective country! You always have to cross-check
                                    and verify with the Rwandan reality.<br><br>

                                    Through the following link you can find information about knowledge,
                                    skills and abilities needed in different professions:
                                    <?= Html::a('click here', 'https://www.mynextmove.org', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']) ?>
                                    <br><br>

                                    The following link goes to a tests page which match your skills to your career :
                                    <?= Html::a('click here', 'http://www.educationplanner.org/students/career-planning/find-careers/careers.shtml', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']) ?>
                                    <br><br>

                                    The International Labour Organisation (ILO) developed a free smartphone
                                    application to support young people to learn more about themselves and
                                    find satisfying careers. It is called Surfing the labour market and
                                    you can find it here for download:
                                    <?= Html::a('click here', 'http://www.ilo.org/global/publications/apps/lang--en/index.htm', ['target' => '_blank', 'class' => 'btn btn-link', 'style' => 'padding: 0px 0px;']) ?>

                                    <!-- Here you can for example find information about knowledge, skills and abilities needed 
                        in different professions.<br><br> -->

                                    <!-- This home page offers you a link to test which career matches your skills: <br> -->

                                    <!-- The International Labour Organisation (ILO) has developed a free smartphone application 
                        to support young people to learn more about themselves and find satisfying careers. <br> -->
                                    <!-- It is called Surfing the labour market and you can find it here to download: <br> -->

                                </div>
                                <!-- <div class="col-md-3" style="padding: 10px; background-color: #f5f5f5">
                        <b>Links</b><br><br>
                        <br>
                        <br>
                        <br>
                    </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <div class="panel panel-primary noborder">

                    <div id="collapse11" class="panel-collapse collapse in">
                        <h3>Job video clips</h3>
                        <div class="panel-body">
                            <p>
                                You are struggling to find a career path and need some inspiration? <br>
                                Becoming a carpenter sounds interesting to you, but you do not know what to
                                expect from the job? <br>
                                From hotel manager to software developer to camera operator, in the video library
                                below you find some job profiles. They will give you a general idea and provide
                                you with basic but essential information on each profession. A great way to start
                                planning your future!
                            </p>
                        </div>
                    </div>
                </div>
                <!-- <div class="panel-group" id="accordion1"> -->
                <div class="panel panel-primary noborder">

                    <div id="collapse3" class="panel-collapse collapse in">
                        <h3>Do you like to organise things?</h3>
                        <div class="panel-body" style="text-align: center">
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=5MOfs3BUH_0&title=Production manager">
                                        <img src="../storage/careerguidance/audiovisual/productionmanager.png">
                                        <br>Production manager
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=p6bcbVDDfXY&title=Tour operator">
                                        <img src="../storage/careerguidance/tourism/touroperator.png">
                                        <br>Tour operator
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=exPZ-8Dop-s&title=House keeping">
                                        <img src="../storage/careerguidance/tourism/housekeeping.png">
                                        <br>House keeping
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=KZHb-MxkWnk&title=Editor">
                                        <img src="../storage/careerguidance/audiovisual/editor.png">
                                        <br>Video editor
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=IIp1DAd5qD4&title=Hotel manager">
                                        <img src="../storage/careerguidance/tourism/hotelmanager.png">
                                        <br>Hotel manager
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=kyna3TOW-WM&title=Cook">
                                        <img src="../storage/careerguidance/tourism/cook.png">
                                        <br>Cook
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary noborder">
                    <div id="collapse4" class="panel-collapse collapse">
                        <h3>Do you like playing with maths?</h3>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=0qjpGR7bFLA&title=Network specialist">
                                        <img src="../storage/careerguidance/ict/networkspecialist.png">
                                        <br>Network speciliast
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=Xhd1BGy_VVo&title=Cyber security">
                                        <img src="../storage/careerguidance/ict/cybersecurity.png">
                                        <br>Cyber security specialist
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary noborder">
                    <!-- <div class="panel-heading">
            <h4 class="panel-title">
                
            </h4>
        </div> -->
                    <div id="collapse5" class="panel-collapse collapse">
                        <h3>Do you like to work with computers?</h3>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=0qjpGR7bFLA&title=Network specialist">
                                        <img src="../storage/careerguidance/ict/networkspecialist.png">
                                        <br>Network specialist
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=Xhd1BGy_VVo&title=Cyber security">
                                        <img src="../storage/careerguidance/ict/cybersecurity.png">
                                        <br>Cyber security specialist
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=sBqXdkzjY7g&title=Software developer">
                                        <img src="../storage/careerguidance/ict/softwaredeveloper.png">
                                        <br>Software developer
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=MNqWU2sqXjc&title=Furniture designer">
                                        <img src="../storage/careerguidance/wood/fournituredesigner.png">
                                        <br>Furniture designer
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=KZHb-MxkWnk&title=Editor">
                                        <img src="../storage/careerguidance/audiovisual/editor.png">
                                        <br>Video editor
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary noborder">
                    <!-- <div class="panel-heading">
            <h4 class="panel-title">
                
            </h4>
        </div> -->
                    <div id="collapse6" class="panel-collapse collapse">
                        <h3>Do you like to create things?</h3>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=sBqXdkzjY7g&title=Software developer">
                                        <img src="../storage/careerguidance/ict/softwaredeveloper.png">
                                        <br>Software developer
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=Hwl0JjvyT68&title=Script writer">
                                        <img src="../storage/careerguidance/audiovisual/scriptwriter.png">
                                        <br>Script writer
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=oxaNj7l9QmU&title=Actor">
                                        <img src="../storage/careerguidance/audiovisual/actor.png">
                                        <br>Actor
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=4BbOCog9Iho&title=Web designer">
                                        <img src="../storage/careerguidance/ict/webdesigner.png">
                                        <br>Web designer
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=MNqWU2sqXjc&title=Furniture designer">
                                        <img src="../storage/careerguidance/wood/fournituredesigner.png">
                                        <br>Furniture designer
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?dir=audiovisual&name=editor&title=Video editor">
                                        <img src="../storage/careerguidance/audiovisual/editor.png">
                                        <br>Video editor
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=2oeyRKU_Qaw&title=Upholster">
                                        <img src="../storage/careerguidance/wood/uphoster.png">
                                        <br>Upholster
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=ewhWAW0d-PM&t=6s&title=Carpenter">
                                        <img src="../storage/careerguidance/wood/carpentry.png">
                                        <br>Carpenter
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=fhbQa77JQa4&title=Joiner">
                                        <img src="../storage/careerguidance/wood/joiner.png">
                                        <br>Joiner
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary noborder">
                    <!-- <div class="panel-heading">
            <h4 class="panel-title">
                
            </h4>
        </div> -->
                    <div id="collapse7" class="panel-collapse collapse">
                        <h3>Do you like to work with your hands?</h3>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=ewhWAW0d-PM&t=6s&title=Carpentry">
                                        <img src="../storage/careerguidance/wood/carpentry.png">
                                        <br>Carpenter
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=kyna3TOW-WM&title=Cook">
                                        <img src="../storage/careerguidance/tourism/cook.png">
                                        <br>Cook
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="id=fhbQa77JQa4&title=Joiner">
                                        <img src="../storage/careerguidance/wood/joiner.png">
                                        <br>Joiner
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=2oeyRKU_Qaw&title=Upholster">
                                        <img src="../storage/careerguidance/wood/uphoster.png">
                                        <br>Upholster
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=exPZ-8Dop-s&title=House keeping">
                                        <img src="../storage/careerguidance/tourism/housekeeping.png">
                                        <br>House keeper
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=YalUBvVpTgc&title=Computer technician">
                                        <img src="../storage/careerguidance/ict/computertechnician.png">
                                        <br>Computer technician
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary noborder">
                    <!-- <div class="panel-heading">
            <h4 class="panel-title">
                
            </h4>
        </div> -->
                    <div id="collapse8" class="panel-collapse collapse">
                        <h3>Do you like to be outside?</h3>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=8XUAqaNbmys&title=Camera operator">
                                        <img src="../storage/careerguidance/audiovisual/cameraoperator.png">
                                        <br>Camera operator
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=__HLIuHXbzM&title=Female driver">
                                        <img src="../storage/careerguidance/ecommerce/femaledriver.png">
                                        <br>Driver
                                    </a>

                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=f8ivCv_xFiE&title=Forest technician">
                                        <img src="../storage/careerguidance/wood/foresttechnician.png">
                                        <br>Forest technician
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=c0B-fE00EVc&title=Nature tour guide">
                                        <img src="../storage/careerguidance/tourism/naturetourguide.png">
                                        <br>Nature tour guide
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary noborder">
                    <!-- <div class="panel-heading">
            <h4 class="panel-title">
                
            </h4>
        </div> -->
                    <div id="collapse9" class="panel-collapse collapse">
                        <h3>Do you like to work in the nature?</h3>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=f8ivCv_xFiE&title=Forest technician">
                                        <img src="../storage/careerguidance/wood/foresttechnician.png">
                                        <br>Forest technician
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=c0B-fE00EVc&title=Nature tour guide">
                                        <img src="../storage/careerguidance/tourism/naturetourguide.png">
                                        <br>Nature tour guide
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=p6bcbVDDfXY&title=Tour operator">
                                        <img src="../storage/careerguidance/tourism/touroperator.png">
                                        <br>Tour operator
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary noborder">
                    <!-- <div class="panel-heading">
            <h4 class="panel-title">
                
            </h4>
        </div> -->
                    <div id="collapse10" class="panel-collapse collapse">
                        <h3>Do you like to work at night?</h3>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=f8ivCv_xFiE&title=Forest technician">
                                        <img src="../storage/careerguidance/wood/foresttechnician.png">
                                        <br>Forest technician
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=c0B-fE00EVc&title=Nature tour guide">
                                        <img src="../storage/careerguidance/tourism/naturetourguide.png">
                                        <br>Nature tour guide
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?dir=ecommerce&name=femaledriver&title=Driver">
                                        <img src="../storage/careerguidance/ecommerce/femaledriver.png">
                                        <br>Driver
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=0qjpGR7bFLA&title=Network specialist">
                                        <img src="../storage/careerguidance/ict/networkspecialist.png">
                                        <br>Network specialist
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=Xhd1BGy_VVo&title=Cyber security">
                                        <img src="../storage/careerguidance/ict/cybersecurity.png">
                                        <br>Cyber security specialist
                                    </a>
                                </div>
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=KZHb-MxkWnk&title=Editor">
                                        <img src="../storage/careerguidance/audiovisual/editor.png">
                                        <br>Video editor
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <a class="btn btn-link" href="videos?id=sBqXdkzjY7g&title=Software developer">
                                        <img src="../storage/careerguidance/ict/softwaredeveloper.png">
                                        <br>Software developer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
<script>
    function displayDistrict() {
        if (document.getElementById('district').style.display == 'none') {
            $('#district').show();
            $('#icon_district').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        } else {
            $('#district').hide();
            $('#icon_district').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        }
    }
</script>