<?php

use common\models\JsEndorse;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>

<div class="row profile">
    <div  class="col-sm-12">


        <div id="endorse" class="content-list content-menu responsive">
            <table class='table table-bordered table-striped'>
                <?php if (isset($_GET['js'])) { ?>
                    <tr>
                        <td colspan="3" style="text-align: left;">
                            <?php
                            $endorseModel = new JsEndorse();
                            Modal::begin([
                                'options' => [
                                    'tabindex' => false // important for Select2 to work properly
                                ],
                                'header' => 'Add endorsement',
                                "class" => "btn btn-success",
                                'toggleButton' => [
                                    'class' => 'btn btn-success',
                                    'label' => 'Add <i class="fa fa-add" aria-hidden="true"></i>'
                                ],
                                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                                    //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                            ]);
                            echo $this->render('/js-endorse/_form', [
                                'model' => $endorseModel,
                                'url' => Yii::$app->link->frontendUrl('/jobseeker/js-endorse/create'),
                                'user_id' => (isset($_GET['js'])) ? $_GET['js'] : 0
                            ]);
                            Modal::end();
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Skills</th>
                    <th>Endorsed by</th>
                    <th>Action</th>
                </tr>
                <?php
                $endorses = $jobseeker->jsEndorses;
                foreach ($endorses as $endorse) {
                    ?>
                    <tr>
                        <td><?= isset($endorse->skill->skill) ? $endorse->skill->skill : '-' ?></td>
                        <td>

                            <?php
                            if (isset($endorse->whoEndorsed->mediatorProfile->madiator_name)) {
                                echo $endorse->whoEndorsed->mediatorProfile->madiator_name;
                            }

                            if (isset($endorse->whoEndorsed->userProfile->fullName)) {
                                echo $endorse->whoEndorsed->userProfile->fullName;
                            }

                            if (isset($endorse->whoEndorsed->employerProfile->company_name)) {
                                echo $endorse->whoEndorsed->employerProfile->company_name;
                            }
                            ?>

                        </td  class="pxp-dashboard-table-options">
                        <td>
                    
                        <a href="#">
                            <?php
                            $endorseModel = JsEndorse::find()->where(['id' => $endorse->id])->one();
                            Yii::$app->jobPortalModal->popup($endorseModel, "Endorse", "blue", "fa fa-eye", "/js-endorse/_view");
                            ?>

                        </a>
                        <?php if (!isset($_GET['js'])) { ?>
                            <a href="#" style="background-color: #e9e9e9"  type="button" value="Cancel" onclick="if (confirm('Are you sure you want to delete ?'))
                                                window.location.href = 'removeitem?endorsementid=<?= $endorse->id ?>';" /><button class="fa fa-trash-o action-button-danger" aria-hidden="true"  ></button>
                            </a>
                        <?php } ?>
                     
                    </td>
                    </tr> 
                <?php } ?>
            </table>
        </div>            


    </div>
</div>	
<script>
    function hideAndShowEndorse() {

        let column = "show_endorsement";
        let variable = $("#input_endorse").val();
        let FRONTEND_BASE_URL = "<?= ($_SERVER['FRONTEND_BASE_URL'] == '/') ? '' : $_SERVER['FRONTEND_BASE_URL'] ?>";

        $.ajax({
            type: "POST",
            url: FRONTEND_BASE_URL + "/jobseeker/user-profile/hide-and-show?variable=" + variable + "&column=" + column,
            dataType: "json",
            success: function (data) {

            }
        });

    }
</script>