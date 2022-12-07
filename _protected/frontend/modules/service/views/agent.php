<!doctype html>
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

        <title>JobPortal </title>
    </head>
    <body style="background-color: var(--pxpMainColorLight);">
        <div class="pxp-preloader"><span>Loading...</span></div>

        <div class="pxp-dashboard-side-panel d-none d-lg-block">
            <div class="pxp-logo">
                <a href="index.html" class="pxp-animate"><img src="images/kora.png" width="82px" height='40px'></a>
                  </div>

            <nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">
                <div class="pxp-dashboard-side-label">Admin tools</div>
                <ul class="list-unstyled">
                    <li class="pxp-active"><a href="company-dashboard.html"><span class="fa fa-home"></span>Dashboard</a></li>
                    <li><a href="company-dashboard-profile.html"><span class="fa fa-pencil"></span>Edit Profile</a></li>
                    <li><a href="signup.html"><span class="fa fa-file-text-o"></span>New job seeker</a></li>
                    <li><a href="candidates-list-2.html"><span class="fa fa-briefcase"></span>My job seekers</a></li>
                       <li><a href="company-dashboard-password.html"><span class="fa fa-lock"></span>Change Password</a></li>
                </ul>
                <div class="pxp-dashboard-side-label mt-3 mt-lg-4">Insights</div>
                <ul class="list-unstyled">
                     
                    <li>
                        <a href="company-dashboard-notifications.html" class="d-flex justify-content-between align-items-center">
                            <div><span class="fa fa-bell-o"></span>Notifications</div>
                            <span class="badge rounded-pill">5</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <nav class="pxp-dashboard-side-user-nav-container">
                <div class="pxp-dashboard-side-user-nav">
                    <div class="dropdown pxp-dashboard-side-user-nav-dropdown dropup">
                        <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="pxp-dashboard-side-user-nav-avatar pxp-cover" style="background-image: url(images/company-logo-1.png);"></div>
                            <div class="pxp-dashboard-side-user-nav-name">Bluhub ltd</div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="company-dashboard.html">Dashboard</a></li>
                            <li><a class="dropdown-item" href="company-dashboard-profile.html">Edit profile</a></li>
                            <li><a class="dropdown-item" href="index.html">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="pxp-dashboard-content">
            <div class="pxp-dashboard-content-header">
                <div class="pxp-nav-trigger navbar pxp-is-dashboard d-lg-none">
                    <a role="button" data-bs-toggle="offcanvas" data-bs-target="#pxpMobileNav" aria-controls="pxpMobileNav">
                        <div class="pxp-line-1"></div>
                        <div class="pxp-line-2"></div>
                        <div class="pxp-line-3"></div>
                    </a>
                    <div class="offcanvas offcanvas-start pxp-nav-mobile-container pxp-is-dashboard" tabindex="-1" id="pxpMobileNav">
                        <div class="offcanvas-header">
                            <div class="pxp-logo">
                                 <a href="index.html" class="pxp-animate"><img src="images/kora.png" width="82px" height='40px'></a>
                 </div>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <nav class="pxp-nav-mobile">
                                <ul class="navbar-nav justify-content-end flex-grow-1">
                                    <li class="pxp-dropdown-header">Admin tools</li>
                                    <li class="nav-item"><a href="company-dashboard.html"><span class="fa fa-home"></span>Dashboard</a></li>
                                    <li class="nav-item"><a href="company-dashboard-profile.html"><span class="fa fa-pencil"></span>Edit Profile</a></li>
                                    <li class="nav-item"><a href="company-dashboard-new-job.html"><span class="fa fa-file-text-o"></span>New Job Offer</a></li>
                                    <li class="nav-item"><a href="company-dashboard-jobs.html"><span class="fa fa-briefcase"></span>Manage Jobs</a></li>
                                    <li class="nav-item"><a href="company-dashboard-candidates.html"><span class="fa fa-user-circle-o"></span>Candidates</a></li>
                                    <li class="nav-item"><a href="company-dashboard-subscriptions.html"><span class="fa fa-credit-card"></span>Subscriptions</a></li>
                                    <li class="nav-item"><a href="company-dashboard-password.html"><span class="fa fa-lock"></span>Change Password</a></li>
                                    <li class="pxp-dropdown-header mt-4">Insights</li>
                                    
                                    <li class="nav-item">
                                        <a href="company-dashboard-notifications.html" class="d-flex justify-content-between align-items-center">
                                            <div><span class="fa fa-bell-o"></span>Notifications</div>
                                            <span class="badge rounded-pill">5</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <nav class="pxp-user-nav pxp-on-light">
                    <a href="company-dashboard-new-job.html" class="btn rounded-pill pxp-nav-btn">Post a Job</a>
                    <div class="dropdown pxp-user-nav-dropdown pxp-user-notifications">
                        <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="fa fa-bell-o"></span>
                            <div class="pxp-user-notifications-counter">5</div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Murenzi</strong> applied for <strong>Software Engineer</strong>. <span class="pxp-is-time">20m</span></a></li>
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>JP</strong> sent you a message. <span class="pxp-is-time">1h</span></a></li>
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Christophe</strong> applied for <strong>Team Leader</strong>. <span class="pxp-is-time">2h</span></a></li>
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Muhirwa</strong> applied for <strong>Software Engineer</strong>. <span class="pxp-is-time">5h</span></a></li>
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Anne marie</strong> sent you a message. <span class="pxp-is-time">1d</span></a></li>
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Turikumwe</strong> applied for <strong>Software Engineer</strong>. <span class="pxp-is-time">3d</span></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item pxp-link" href="company-dashboard-notifications.html">Read All</a></li>
                        </ul>
                    </div>
                    <div class="dropdown pxp-user-nav-dropdown">
                        <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="pxp-user-nav-avatar pxp-cover" style="background-image: url(images/company-logo-1.png);"></div>
                            <div class="pxp-user-nav-name d-none d-md-block">Bluhub ltd</div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="company-dashboard.html">Dashboard</a></li>
                            <li><a class="dropdown-item" href="company-dashboard-profile.html">Edit profile</a></li>
                            <li><a class="dropdown-item" href="index.html">Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="pxp-dashboard-content-details">
                <h1>Dashboard</h1>
                <p class="pxp-text-light">Welcome to Your Kora Job  Portal</p>

                <div class="row mt-4 align-items-center">
                    <div class="col-sm-6 col-xxl-3">
                        <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                            <div class="pxp-dashboard-stats-card-icon text-primary">
                                <span class="fa fa-file-text-o"></span>
                            </div>
                            <div class="pxp-dashboard-stats-card-info">
                                <div class="pxp-dashboard-stats-card-info-number">13</div>
                                <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Open Jobs </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                            <div class="pxp-dashboard-stats-card-icon text-success">
                                <span class="fa fa-user-circle-o"></span>
                            </div>
                            <div class="pxp-dashboard-stats-card-info">
                                <div class="pxp-dashboard-stats-card-info-number">312</div>
                                <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Job seekers</div>
                            </div>
                        </div>
                    </div>
                     
                    <div class="col-sm-6 col-xxl-3">
                        <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                            <div class="pxp-dashboard-stats-card-icon text-danger">
                                <span class="fa fa-bell-o"></span>
                            </div>
                            <div class="pxp-dashboard-stats-card-info">
                                <div class="pxp-dashboard-stats-card-info-number">5</div>
                                <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Notifications</div>
                            </div>
                        </div>
                    </div>
                </div>

               

               

                <div class="mt-4">
                    <h2>Recent job seekers [<a href="company-dashboard-candidates.html"> View All</a> ]</h2>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <tr>
                                <td style="width: 3%;"><div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-name">Vunabandi JMV</div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-title">UI Designer</div></td>
                                <td><div class="pxp-company-dashboard-candidate-location"><span class="fa fa-globe"></span>Kist</div></td>
                                <td>
                                    <div class="pxp-dashboard-table-options">
                                        <ul class="list-unstyled">
                                            <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                             
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 3%;"><div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-name">Nkubito Eric</div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-title">Software Developer</div></td>
                                <td><div class="pxp-company-dashboard-candidate-location"><span class="fa fa-globe"></span>Ulk</div></td>
                                <td>
                                    <div class="pxp-dashboard-table-options">
                                        <ul class="list-unstyled">
                                            <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                             
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 3%;"><div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-name">Nkurunziza Eddy</div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-title">Marketing Expert</div></td>
                                <td><div class="pxp-company-dashboard-candidate-location"><span class="fa fa-globe"></span>UCA</div></td>
                                <td>
                                    <div class="pxp-dashboard-table-options">
                                        <ul class="list-unstyled">
                                            <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                             
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 3%;"><div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-name">Rugamba JP</div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-title">PhP Developer</div></td>
                                <td><div class="pxp-company-dashboard-candidate-location"><span class="fa fa-globe"></span>India,Annamalai</div></td>
                                 
                            </tr>
                            <tr>
                                <td style="width: 3%;"><div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-name">Scott Goodwin</div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-title">UI Designer</div></td>
                                <td><div class="pxp-company-dashboard-candidate-location"><span class="fa fa-globe"></span>London, UK</div></td>
                                <td>
                                    <div class="pxp-dashboard-table-options">
                                        <ul class="list-unstyled">
                                            <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                             
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 3%;"><div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-name">Mutemberezi</div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-title">Software Developer</div></td>
                                <td><div class="pxp-company-dashboard-candidate-location"><span class="fa fa-globe"></span>Ulk</div></td>
                                <td>
                                    <div class="pxp-dashboard-table-options">
                                        <ul class="list-unstyled">
                                            <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                               
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 3%;"><div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-name">Peter </div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-title">Marketing Expert</div></td>
                                <td><div class="pxp-company-dashboard-candidate-location"><span class="fa fa-globe"></span>Kist</div></td>
                                <td>
                                    <div class="pxp-dashboard-table-options">
                                        <ul class="list-unstyled">
                                            <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                             
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 3%;"><div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-name">Mugabekazi</div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-title">Architect</div></td>
                                <td><div class="pxp-company-dashboard-candidate-location"><span class="fa fa-globe"></span>Unilak</div></td>
                                <td>
                                    <div class="pxp-dashboard-table-options">
                                        <ul class="list-unstyled">
                                            <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                             
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 3%;"><div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-name">Hitimana Sylvain</div></td>
                                <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-title">UI Designer</div></td>
                                <td><div class="pxp-company-dashboard-candidate-location"><span class="fa fa-globe"></span>London, UK</div></td>
                                <td>
                                    <div class="pxp-dashboard-table-options">
                                        <ul class="list-unstyled">
                                            <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                              
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                             
                        </table>
                    </div>
                </div>
            </div>

            <footer>
                <div class="pxp-footer-copyright pxp-text-light">© 2022 JobPortal. All Right Reserved.</div>
            </footer>
        </div>

        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/nav.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>