<!doctype html>
<html lang="en" class="pxp-root">
    <head>
        

        <title>Jobportal </title>
    </head>
    <body style="background-color: var(--pxpMainColorLight);">
        <div class="pxp-preloader"><span>Loading...</span></div>

        <div class="pxp-dashboard-side-panel d-none d-lg-block">
            

            <nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">
                
                
                
            </nav>

          
        </div>
        <div class="pxp-dashboard-content">
            <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/seeker_top_header.php") ?>
    

            <div class="pxp-dashboard-content-details">
                
                <div class="mt-4 mt-lg-5">
                    
                    <div class="table-responsive table-hover">
                         
                             
                            <?php echo $content ?> 
                                    
                                     
                                 

                        
                    </div>
                </div>
            </div>

             
        </div>

     
    </body>
</html>