<?php

use common\models\JsTraining;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>

<div class="row profile">
    <div  class="col-sm-12">


        <div id="training" class="content-list content-menu">
            <table class='table table-bordered table-striped'>
                <?php if (!isset($_GET['js'])) { ?>
                    <tr>
                        <td colspan="7" style="text-align: left;" >
                            <?php
                            $trainingModel = new JsTraining();
                            Yii::$app->jobPortalModal
                                    ->popup(
                                            $trainingModel,
                                            "Add training",
                                            "btn rounded-pill pxp-nav-btn",
                                            "fa fa-plus",
                                            "/js-training/_form",
                                            "/jobseeker/js-training/create",
                                            "Add"
                            );
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Training center</th>
                    <th>Training title</th>
                    <th>Certificate</th>
                    <?php if (Yii::$app->user->can('user')) { ?>
                        <th style="width: auto">Action</th>
                    <?php } ?>
                </tr>
                <?php
                $trainings = $jobseeker->jsTrainings;
                foreach ($trainings as $training) {
                    ?>
                    <tr>
                        <td><?= $training->training_center; ?></td>
                        <td><?= $training->training_title; ?></td>
                        <td>
                            <?= isset($training->certificate_path) ? '<a class="btn btn-success" target="_blank" href=' . Yii::getAlias('@storageUrl') . '/source/1/' . $training->certificate_path . '><i class="fa fa-download"></i>Download</a>' : "<center><code>No Certificate</code></center>"; ?>
                        </td>    
                        <?php if (Yii::$app->user->can('user')) { ?>         
                            <td  class="pxp-dashboard-table-options">
                                <a href="#">
                                    <?php
                                    $trainingModel = JsTraining::find()->where(['id' => $training->id])->one();
                                    Yii::$app->jobPortalModal->popup($trainingModel, "View training", "blue", "fa fa-eye", "/js-training/_view");
                                    ?>
                                </a>
                                <?php if (!isset($_GET['js'])) { ?>
                                    <a href="#">
                                        <?php
                                        $trainingModel = JsTraining::find()->where(['id' => $training->id])->one();
                                        Yii::$app->jobPortalModal
                                                ->popup(
                                                        $trainingModel,
                                                        "training",
                                                        "green",
                                                        "fa fa-pencil",
                                                        "/js-training/_form",
                                                        '/jobseeker/js-training/update?id=' . $trainingModel->id
                                        );
                                        ?>
                                    </a>
                                    <a href="#" style="background-color: #e9e9e9"  type="button" value="Cancel" onclick="if (confirm('Are you sure you want to delete ?'))
                                                            window.location.href = 'removeitem?trainingid=<?= $trainingModel->id ?>';" /><button class="fa fa-trash-o action-button-danger" aria-hidden="true" ></button>
                                    </a>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    </tr> 
                <?php } ?>	  	
            </table>
        </div>            


    </div>
</div>	
<script>
    function hideAndShowTraining() {

        let column = "show_training";
        let variable = $("#input_training").val();
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