<?php

use common\models\JsEducation;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>

<div class="row profile">
    <div  class="col-sm-12">

        <div id="education" class="responsive">
            <table class='table  table-bordered table-striped'>
<?php if (!isset($_GET['js'])) { ?>
                    <tr>
                        <td colspan="6" style="text-align: left;">
                            <?php
                            $educationModel = new JsEducation();
                            Yii::$app->jobPortalModal
                                    ->popup(
                                            $educationModel,
                                            "Add Education",
                                            "green",
                                            "plus",
                                            "/js-education/_form",
                                            "/jobseeker/js-education/create",
                                            "Add"
                            );
                            ?>
                        </td>
                    </tr>
<?php } ?>
                <tr>
                    <th>School</th>
                    <th>Education field</th>
                    <th>Degree</th>
                    <?php if (Yii::$app->user->can('user')) { ?>
                        <th>Action</th>
                <?php } ?>
                </tr>
                <?php
                $educations = $jobseeker->jsEducations;
                foreach ($educations as $education) {
                    ?>
                    <tr>
                        <td><?= $education->school; ?></td>
                        <td><?= isset($education->educationField->field) ? $education->educationField->field : "-"; ?></td>
                        <td>
                        <?= isset($education->certificate_path) ? '<a class="btn btn-success" target="_blank" href=' . Yii::getAlias('@storageUrl') . '/source/1/' . $education->certificate_path . '><i class="fa fa-download"></i>Download</a>' : "<center><code>No Degree</code></center>"; ?>
                        </td>
    <?php if (Yii::$app->user->can('user')) { ?>
                            <td  class="pxp-dashboard-table-options">

                                <a href="#">
                                    <?php
                                    $educationModel = JsEducation::find()->where(['id' => $education->id])->one();
                                    Yii::$app->jobPortalModal->popup($educationModel, "View Education", "blue", "fa fa-eye", "/js-education/_view");
                                    ?>
                                </a>
                                    <?php if (!isset($_GET['js'])) { ?>
                                    <a href="#">
                                        <?php
                                        $educationModel = JsEducation::find()->where(['id' => $education->id])->one();
                                        Yii::$app->jobPortalModal
                                                ->popup(
                                                        $educationModel,
                                                        "education",
                                                        "green",
                                                        "fa fa-pencil",
                                                        "/js-education/_form",
                                                        '/jobseeker/js-education/update?id=' . $educationModel->id
                                        );
                                        ?>	
                                    </a>
                                    <a href="#" style="background-color: #e9e9e9"        type="button" value="Cancel" onclick="if (confirm('Are you sure you want to delete ?'))
                                                window.location.href = 'removeitem?educationid=<?= $educationModel->id ?>';" /><button class="fa fa-trash-o action-button-danger" aria-hidden="true"  ></button>
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
    function hideAndShowEducation() {

        let column = "show_education";
        let variable = $("#input_education").val();
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