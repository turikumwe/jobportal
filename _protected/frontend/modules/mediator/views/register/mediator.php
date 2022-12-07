 <?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<html>
<body className='snippet-body' style="background-color:#eee">
     <?php include(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'header.php') ?>
<br />
                                <div class="pxp-container">
                                   
                                    <div class="container">
    <div class="card">
         <?php
                $form = ActiveForm::begin([
                    'id' => 'register/mediator',
                    'options' => ['method'=>'post','enctype' => 'multipart/form-data']
                ])?>
                     
        <div class="form">
            <div class="left-side">
                <div class="left-heading">
                    <h3>Agent Account</h3>
                </div>
                <div class="steps-content">
                    <h3>Step <span class="step-number">1</span></h3>
                    
                </div>
                <ul class="progress-bar" style="background-color:#304767 ">
                    <li class="active">Login Information</li>
                    <li>Personal Info</li>
                   
                     
                </ul>
                

                
            </div>
            <div class="right-side">
                <div class="main active" >
                     
                    <div class="text">
                        <h2><i class="fa fa-sign-in"></i> Login Information</h2>
                        <p>Enter your Login information .</p>
                        <?php     if (Yii::$app->getSession()->hasFlash('alert')) { ?> 
                <div class="<?= Yii::$app->getSession()->getFlash('alert')["options"]["class"] ?>">
                    <p><?= Yii::$app->getSession()->getFlash('alert')['body'] ?></p>
                </div>
            <?php } ?>
                    </div>
                    <div class="input-text">
                         <?php include('mediatorForm.php');?> 
                    </div>
                     
                     <hr/>
                    <div class="buttons">
                        <button class="next_button" type="button">Next Step</button>
                    </div>
                </div>
                <div class="main">
                    
                    <div class="text">
                        <h2><i class="fa fa-user"></i> Your Personal Information</h2>
                        <p>Enter your personal information  </p>
                    </div>
                    <div class="row mt-4">
                        <?php include('_personForm.php');?>  
                    </div>
                    
                    <hr />
                    <div class="buttons button_space">
                        <button class="back_button" type="button">Back</button>
                        <?php echo Html::submitButton(Yii::t('frontend', 'Register'), ['class' => 'btn btn-success', 'name' => 'register-button']) ?>
  </div>
                </div>
                 
                
                
                
               
                  
                
            
              

            

            </div>
        </div>
         <?php ActiveForm::end(); ?>
    </div>
</div></div>
                                <script type='text/javascript' src='#'></script>
                                <script type='text/javascript' src='#'></script>
                                <script type='text/javascript' src='#'></script>
                                <script type='text/javascript' src='#'></script>
                                <script type='text/javascript'>var next_click=document.querySelectorAll(".next_button");
var main_form=document.querySelectorAll(".main");
var step_list = document.querySelectorAll(".progress-bar li");
var num = document.querySelector(".step-number");
let formnumber=0;

next_click.forEach(function(next_click_form){
    next_click_form.addEventListener('click',function(){
        if(!validateform()){
            return false
        }
       formnumber++;
       updateform();
       progress_forward();
       contentchange();
    });
}); 

var back_click=document.querySelectorAll(".back_button");
back_click.forEach(function(back_click_form){
    back_click_form.addEventListener('click',function(){
       formnumber--;
       updateform();
       progress_backward();
       contentchange();
    });
});

var username=document.querySelector("#user_name");
var shownname=document.querySelector(".shown_name");
 

var submit_click=document.querySelectorAll(".submit_button");
submit_click.forEach(function(submit_click_form){
    submit_click_form.addEventListener('click',function(){
       shownname.innerHTML= username.value;
       formnumber++;
       updateform(); 
    });
});

var heart=document.querySelector(".fa-heart");
heart.addEventListener('click',function(){
   heart.classList.toggle('heart');
});


var share=document.querySelector(".fa-share-alt");
share.addEventListener('click',function(){
   share.classList.toggle('share');
});

 

function updateform(){
    main_form.forEach(function(mainform_number){
        mainform_number.classList.remove('active');
    })
    main_form[formnumber].classList.add('active');
} 
 
function progress_forward(){
    // step_list.forEach(list => {
        
    //     list.classList.remove('active');
         
    // }); 
    
     
    num.innerHTML = formnumber+1;
    step_list[formnumber].classList.add('active');
}  

function progress_backward(){
    var form_num = formnumber+1;
    step_list[form_num].classList.remove('active');
    num.innerHTML = form_num;
} 
 
var step_num_content=document.querySelectorAll(".step-number-content");

 function contentchange(){
     step_num_content.forEach(function(content){
        content.classList.remove('active'); 
        content.classList.add('d-none');
     }); 
     step_num_content[formnumber].classList.add('active');
 } 
 
 
function validateform(){
    validate=true;
    var validate_inputs=document.querySelectorAll(".main.active input");
    validate_inputs.forEach(function(vaildate_input){
        vaildate_input.classList.remove('warning');
        if(vaildate_input.hasAttribute('require')){
            if(vaildate_input.value.length==0){
                validate=false;
                vaildate_input.classList.add('warning');
            }
        }
    });
    return validate;
    
}</script>
                                <script type='text/javascript'>var myLink = document.querySelector('a[href="#"]');
                                myLink.addEventListener('click', function(e) {
                                  e.preventDefault();
                                });</script>
                                </body>