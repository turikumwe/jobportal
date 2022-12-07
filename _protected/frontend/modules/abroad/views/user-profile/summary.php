<?php
use common\models\JsSummary;
use yii\bootstrap\Modal;
use yii\helpers\Html;

?>
<div class="row profile" style="margin-bottom: 10px;">
    <div  class="col-sm-12">
        <?php kak\widgets\fieldset\FieldSet::begin([
        'legend' => Yii::t('frontend', '<span class="mgbt-xs-15 font-semibold"><i class="glyphicon glyphicon-list-alt"></i> Summary</span>'),
        'active' => false,// false - hide content, default true
        // 'speed'  => 0, // animation speed default value 300
        'dataUp' => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-up'></i></div>",     // template content icon
        'dataDown'  => "<div class='pull-right'><i class='glyphicon glyphicon-collapse-down'></i></div>",   // template content icon
        ]);?>			
            <div id="summary" class="content-list content-menu responsive">
            <table class='table table-striped'>
                <?php if (!isset($_GET['idOtherProfile']) && JsSummary::find()->where(['user_id' => Yii::$app->user->id,'deleted_by' => 0])->count() == 0) { ?>
                <tr>
                    <td colspan="5" style="text-align: left">
                            <?php
                                $summaryModel = new JsSummary();
                                Modal::begin([
                                        'options' => [
                                            'tabindex' => false // important for Select2 to work properly
                                        ],
                                    'header' => 'Add summary',
                                    "class" => "vd_bg-green",
                                    'toggleButton' => [
                                        'class' => 'btn vd_btn btn-xs vd_bg-green',
                                        'label' => 'Add <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>'
                                    ],
                                    'footer'=> ''
                                ]);
                                    echo $this->render('/js-summary/_form', [
                                            'model' => $summaryModel,
                                            'url'   => Yii::$app->link->frontendUrl('/jobseeker/js-summary/create')
                                        ]);
                                Modal::end();
                        ?>
                    </td>
                </tr>
            <?php } ?>

                <?php
                    $summaries = $jobseeker->jsSummaries;
                    foreach ($summaries as $summary) {
                        ?>
                <tr>
                    <td colspan="2" class="pull-left">
                        <?php if (!isset($_GET['idOtherProfile'])) { ?>
                        <a href="#summary" class="btn vd_btn btn-xs vd_bg-red" onClick='remove(<?= $summary->id?>", js-summary","summary")'>
                            <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                        </a>
                        <?php } ?>			
                    </td>
                </tr>
                    <tr>
                    <td>
                        <b>Job seeker summary</b>
                        &nbsp;&nbsp;
                            <?php
                                $summaryModel = JsSummary::find()->where(['id' => $summary->id])->one();
                        Modal::begin([
                                        'header' => '<span  style="color:black" >View Professional profile</span>',
                                        "class" => "vd_bg-green",
                                        'toggleButton' => [
                                            'class' => 'btn vd_btn btn-xs vd_bg-blue',
                                            'label' => '<i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>'
                                        ],
                                        'footer'=> ''
                                    ]);
                        echo $this->render('/js-summary/_view_professional_profile', [
                                                'model' => $summaryModel,
                                                
                                            ]);
                        Modal::end(); ?>
                        
                        <?php if (!isset($_GET['idOtherProfile'])) { ?>
                    
                            <?php
                                $summarModel = JsSummary::find()->where(['id' => $summary->id])->one();
                                Modal::begin([
                                            'options' => [
                                                'tabindex' => false // important for Select2 to work properly
                                            ],
                                        'header' => 'Update Professional profile',
                                        "class" => "vd_bg-green",
                                        'toggleButton' => [
                                            'class' => 'btn vd_btn btn-xs vd_bg-green',
                                            'label' => '<i class="glyphicon glyphicon-edit" aria-hidden="true"></i>'
                                        ],
                                        'footer'=> ''
                                    ]);
                                        echo $this->render('/js-summary/_form_professional_profile', [
                                                'model' => $summarModel,
                                                'url'   => Yii::$app->link->frontendUrl('/jobseeker/js-summary/update?id='.$summaryModel->id)
                                            ]);
                                    Modal::end();
                                ?>
                    
                        <?php } ?>
                    </br></br>
                        <?= $summary->professional_profile?>
                    
                    </td>
                    </tr>

                    <tr>
                    <td>
                        <b>Cover Letter</b>  &nbsp;&nbsp;
                            <?php
                                $summaryModel = JsSummary::find()->where(['id' => $summary->id])->one();
                        Modal::begin([
                                        'header' => '<span  style="color:black" >View Cover Letter</span>',
                                        "class" => "vd_bg-green",
                                        'toggleButton' => [
                                            'class' => 'btn vd_btn btn-xs vd_bg-blue',
                                            'label' => '<i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>'
                                        ],
                                        'footer'=> ''
                                    ]);
                        echo $this->render('/js-summary/_view_cover_letter', [
                                                'model' => $summaryModel,
                                                
                                            ]);
                        Modal::end(); ?>
                        <?php if (!isset($_GET['idOtherProfile'])) { ?>
                            <?php
                                $summarModel = JsSummary::find()->where(['id' => $summary->id])->one();
                                Modal::begin([
                                            'options' => [
                                                'tabindex' => false // important for Select2 to work properly
                                            ],
                                        'header' => 'Update Cover Letter',
                                        "class" => "vd_bg-green",
                                        'toggleButton' => [
                                            'class' => 'btn vd_btn btn-xs vd_bg-green',
                                            'label' => '<i class="glyphicon glyphicon-edit" aria-hidden="true"></i>'
                                        ],
                                        'footer'=> ''
                                                //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                                    ]);
                                        echo $this->render('/js-summary/_form_cover_letter', [
                                                'model' => $summarModel,
                                                'url'   =>  Yii::$app->link->frontendUrl('/jobseeker/js-summary/update?id='.$summaryModel->id)
                                            ]);
                                    Modal::end();
                                ?>
                        <?php } ?>
                        <br><br>
                        <?= $summary->cover_letter?>
                    </td>
                    </tr>

                    <tr>
                        <td>
                            <b>Specialty</b>&nbsp;&nbsp;
                                    
                            <?php if (!isset($_GET['idOtherProfile'])) { ?>
                            <?php
                                $summaryModel = JsSummary::find()->where(['id' => $summary->id])->one();
                                Modal::begin([
                                        'header' => '<span  style="color:black" >View summary</span>',
                                        "class" => "vd_bg-green",
                                        'toggleButton' => [
                                            'class' => 'btn vd_btn btn-xs vd_bg-blue',
                                            'label' => '<i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>'
                                        ],
                                        'footer'=> ''
                                    ]);
                                        echo $this->render('/js-summary/_view_speciality', [
                                                'model' => $summaryModel,
                                                
                                            ]);
                                    Modal::end();
                                ?>
                            <?php
                                $summarModel = JsSummary::find()->where(['id' => $summary->id])->one();
                                Modal::begin([
                                            'options' => [
                                                'tabindex' => false // important for Select2 to work properly
                                            ],
                                        'header' => 'Update summary',
                                        "class" => "vd_bg-green",
                                        'toggleButton' => [
                                            'class' => 'btn vd_btn btn-xs vd_bg-green',
                                            'label' => '<i class="glyphicon glyphicon-edit" aria-hidden="true"></i>'
                                        ],
                                        'footer'=> ''
                                    ]);
                                        echo $this->render('/js-summary/_form_speciality', [
                                                'model' => $summarModel,
                                                'url'   =>  Yii::$app->link->frontendUrl('/jobseeker/js-summary/update?id='.$summaryModel->id)
                                            ]);
                                    Modal::end();
                                ?>
                        <?php } ?>
                        <br><br>
                        <?= $summary->specialty; ?>
                        </td>              
                    </tr> 

                    <tr>
                    <td>
                        <b>CV</b>  &nbsp;&nbsp;
                        <?php if (!isset($_GET['idOtherProfile'])) { ?>
                            <?php
                                $summarModel = JsSummary::find()->where(['id' => $summary->id])->one();
                                Modal::begin([
                                            'options' => [
                                                'tabindex' => false // important for Select2 to work properly
                                            ],
                                        'header' => 'Update CV',
                                        "class" => "vd_bg-green",
                                        'toggleButton' => [
                                            'class' => 'btn vd_btn btn-xs vd_bg-green',
                                            'label' => '<i class="glyphicon glyphicon-edit" aria-hidden="true"></i>'
                                        ],
                                        'footer'=> ''
                                                //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                                    ]);
                                        echo $this->render('/js-summary/_formCV', [
                                                'model' => $summarModel,
                                                'url'   =>  Yii::$app->link->frontendUrl('/jobseeker/js-summary/update?id='.$summaryModel->id)
                                            ]);
                                    Modal::end();
                                ?>
                        <?php } ?>
                        <br><br>
                        <a class="btn btn-success" target="_blank" href="<?= $summary->cv_base_url.'/'.$summary->cv_path?>"> View CV</a>
                    </td>
                    </tr>
                <?php
                    } ?>
            </table>
        <?php kak\widgets\fieldset\FieldSet::end(); ?>
    </div>
</div>	
	
<script>
	function hideAndShowSummary(){
	
	let column = "show_profile_summary";
	let variable = $("#input_summary").val();
	let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>"; 

	$.ajax({
	        type: "POST",
	        url: FRONTEND_BASE_URL+"/jobseeker/user-profile/hide-and-show?variable="+variable+"&column="+column,
	        dataType: "json",
	        success: function(data){ 

	        }
	});

	}
</script>