 <?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<script>
const sectionContent = ["r1", "r2", "r3", "r4"];
let currentSection = sectionContent[0];

const displayContent = (q, area) => {
    document.getElementById(q).classList.add("active");
    document.getElementById(q + "-button").classList.add("button-active");
    currentSection = sectionContent[area.indexOf(q)];
    const toNone = area.filter(e => e !== q);
    for (i in toNone) {
        document.getElementById(toNone[i]).classList.remove("active");
        document.getElementById(toNone[i] + "-button").classList.remove("button-active");
    }
    if (sectionContent.indexOf(q) == 0) {
        document.getElementById("previous").classList.remove("button-active");
        document.getElementById("next").classList.add("button-active");
    }
    else if (sectionContent.indexOf(q) == sectionContent.length - 1) {
        document.getElementById("previous").classList.add("button-active");
        document.getElementById("next").classList.remove("button-active");
    } else {
        document.getElementById("previous").classList.add("button-active");
        document.getElementById("next").classList.add("button-active");
    }
}

const displayR1 = () => displayContent("r1", sectionContent);
const displayR2 = () => displayContent("r2", sectionContent);
const displayR3 = () => displayContent("r3", sectionContent);
const displayR4 = () => displayContent("r4", sectionContent);

const displayNext = () => displayContent(sectionContent[sectionContent.indexOf(currentSection) + 1], sectionContent);
const displayPrevious = () => displayContent(sectionContent[sectionContent.indexOf(currentSection) - 1], sectionContent);
</script>
<style>
.container {
    display: grid;
    place-items: center;
}

.section {
display: none;
}

.section.active {
display: block;
}

.nav {
list-style: none;
margin:0;
padding: 0;
display: flex;
align-items: center;
}
.nav button {
background-color: #ccc;
padding: 10px 15px;
margin-left: 6px;
border-radius: 2%;
cursor: pointer;
opacity: .5;
border: none;
}

.next,
.previous {
padding: 15px 10px;
border-radius: 6px;
background-color: #ccc;
color: white;
border:0;
align-items:left;
outline: none;
cursor: pointer;
width: 100px;
visibility: hidden;
}

.button-active {
opacity: 1 !important;
visibility: visible;
}
</style>
<html lang="en" class="pxp-root">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/owl.carousel.min.css">
        <link rel="stylesheet" href="css/owl.theme.default.min.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/style.css">

        <title>JobPortal</title>
    </head>
	<header class="pxp-header fixed-top">
            <div class="pxp-container">
                <div class="pxp-header-container">
                    <div class="pxp-logo">
                        <a href="../../jobportal" class="pxp-animate"><img src="../static/images/kora.png" width="82px" height='40px'></a>
                    </div>
                    <div class="pxp-nav-trigger navbar d-xl-none flex-fill">
                        <a role="button" data-bs-toggle="offcanvas" data-bs-target="#pxpMobileNav" aria-controls="pxpMobileNav">
                            <div class="pxp-line-1"></div>
                            <div class="pxp-line-2"></div>
                            <div class="pxp-line-3"></div>
                        </a>
                        <div class="offcanvas offcanvas-start pxp-nav-mobile-container" tabindex="-1" id="pxpMobileNav">
                            <div class="offcanvas-header">
                                 
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <nav class="pxp-nav-mobile">
                                    <ul class="navbar-nav justify-content-end flex-grow-1">
                                        <li class="nav-item dropdown">
                                            <a role="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Home</a>
                                             
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a role="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Opportunities</a>
                                             
                                        </li>
                                         <li class="nav-item dropdown">
                                            <a href="company-dashboard-jobs.html" role="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Jobs</a>
                                             
                                        </li>
										<li class="nav-item dropdown">
                                            <a href="joobseeker.html" role="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Jobseeker</a>
                                             
                                        </li>
										<li class="nav-item dropdown">
                                            <a href="company-dashboard.html" role="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Employer</a>
                                             
                                        </li>
										<li class="nav-item dropdown">
                                            <a href="agent.html" role="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Agent</a>
                                             
                                        </li>
                                         
                                         
                                         
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <nav class="pxp-nav dropdown-hover-all d-none d-xl-block">
                        <ul>
                            <li class="dropdown">
                                <a href="jobportal" class="dropdown-toggle" data-bs-toggle="dropdown">Home</a>
                                
                                     
                            </li>
                             
                         <li class="nav-item dropdown">
                                            <a href="jobs-list-3.html" role="button" class="nav-item">Find Job</a>
                                             
                                        </li>
                 
                            <li class="nav-item dropdown">
                                            <a href="candidate-dashboard.html" role="button" class="nav-item">Jobseeker</a>
                                             
                                        </li>
										<li class="nav-item dropdown">
                                            <a href="company-dashboard.html" role="button" class="nav-item">Employer</a>
                                             
                                        </li>
										<li class="nav-item dropdown">
                                            <a href="agent.html" role="button" class="nav-item">Agent</a>
                                             
                                        </li>
                             
                        </ul>
                    </nav>
                    <nav class="pxp-user-nav d-none d-sm-flex">
                        <a href="account.html" class="btn rounded-pill pxp-nav-btn">Create Account</a>
                        <a class="btn rounded-pill pxp-user-nav-trigger pxp-on-light" data-bs-toggle="modal" href="#pxp-signin-modal" role="button">Sign in</a>
                    </nav>
                </div>
            </div>
        </header><br><br>
    <body style="background-color: var(--pxpMainColorLight);">
        <div class="pxp-preloader"><span>Loading...</span></div>

        <div class="pxp-dashboard-side-panel d-none d-lg-block">
             

           

             
        </div>
        <div class="pxp-dashboard-content">
            <div class="pxp-dashboard-content-header">
                <div class="pxp-nav-trigger navbar pxp-is-dashboard d-lg-none">
                    <a role="button" data-bs-toggle="offcanvas" data-bs-target="#pxpMobileNav" aria-controls="pxpMobileNav">
                        <div class="pxp-line-1"></div>
                        <div class="pxp-line-2"></div>
                        <div class="pxp-line-3"></div>
                    </a>
                     
                </div>
                
            </div>

            <div class="pxp-dashboard-content-details">
                <h1>Signup Form</h1>
                <p class="pxp-text-light">All Field with * are required.</p>
          
                 
				<nav class="nav">
            <button class="button-active" id="r1-button" onclick="displayR1()"><i class="fa fa-sign-in"></i> LOGIN INFORMATION</button>
            <button id="r2-button" onclick="displayR2()"><i class="fa fa-id-card"></i> IDENTIFICATION</button>
            <button id="r3-button" onclick="displayR3()"><i class="fa fa-graduation-cap"></i> EDUCATION</button>
            <button id="r4-button" onclick="displayR4()"><i class="fa fa-info-circle"></i> ADDITIONAL INFO</button>
        </nav>
                
                     <?php     if (Yii::$app->getSession()->hasFlash('alert')) { ?> 
                <div class="<?= Yii::$app->getSession()->getFlash('alert')["options"]["class"] ?>">
                    <p><?= Yii::$app->getSession()->getFlash('alert')['body'] ?></p>
                </div>
            <?php } ?>
                 <?php
                $form = ActiveForm::begin([
                    'id' => 'form-register-jobseeker',
                    'options' => ['enctype' => 'multipart/form-data']
                ])?>
		<section id="r1" class="section active">
	<br><br><h4> </h4>	
                    <div class="row mt-4 mt-lg-5">
                        <div class="col-xxl-3">
                           <?php include('userForm.php'); ?>     
                        
                    </div></section>
               
					<section id="r2" class="section">
					<br><br><h4> </h4>
                    <div class="row mt-4 mt-lg-5">
                         <?php include('identificationForm.php'); ?>    
                    </div></section>
                  
					<section id="r3" class="section">
				<br><br>	<h4> </h4>
                    <div class="row mt-4 mt-lg-5">
        <?php include('educationForm.php'); ?>  
                    </div></section>
                <section id="r4" class="section">
				<br><br>	<h4> </h4>
                    <div class="row mt-4 mt-lg-5">
        <?php include('additionInformationForm.php'); ?> 
                    </div><br>
                <?php echo Html::submitButton(Yii::t('frontend', 'Register'), ['class' => 'btn btn-success', 'name' => 'register-button']) ?>

                </section>
                <?php ActiveForm::end(); ?>

                    

                     
<nav>
            <button class="btn btn-primary" id="previous" onclick="displayPrevious()"><i class="fa fa-arrow-left"></i> Previous </button>
            <button class="btn btn-primary" id="next" onclick="displayNext()">Next <i class="fa fa-arrow-right"></i></button>
				 
        </nav>
                    <div class="mt-4 mt-lg-5">
                        
                    </div>
                
            </div>

            <footer>
                <div class="pxp-footer-copyright pxp-text-light">© 2022 JobPortal. All Right Reserved.</div>
            </footer>
        </div>

        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/nav.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>