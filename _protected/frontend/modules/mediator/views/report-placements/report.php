<!doctype html>
<html lang="en" class="pxp-root">
    <head>
        

        <title>Jobportal </title>
    </head>
    <body style="background-color: var(--pxpMainColorLight);">
        <div class="pxp-preloader"><span>Loading...</span></div>

        <div class="pxp-dashboard-side-panel d-none d-lg-block">
            

            <nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">
                
                <ul class="list-unstyled">
                    <li> <?php include('leftindex.php'); ?></li>
                     
                       </ul>
                
            </nav>

          
        </div>
        <div class="pxp-dashboard-content">
            <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/seeker_top_header.php") ?>
    

            <div class="pxp-dashboard-content-details">
                    <div class="mt-4">
                    
                    <div class="table-responsive table-hover">
                         
                             
                            <?php echo $content ?> 
                                    
                                     
                                 

                        
                    </div>
                </div>
            </div>

             
        </div>

        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/nav.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>