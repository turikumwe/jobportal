<?php

use common\models\JsSkill;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<script LANGUAGE="JavaScript">
<!--
    function confirmSubmit()
    {
        a.href = 'https://www.google.com';
        var agree = confirm("Are you sure you wish to continue?");
        if (agree)
        {
            a.click();
        } else
            return false;
    }
// -->
</script>
<div class="row profile">
	<div  class="col-sm-12">

			<div id="skill" class="content-list content-menu responsive">
    <table class='table table-bordered table-striped'>
        <?php if (!isset($_GET['js'])) { ?>
                <tr>					   		
                    <td colspan="3" style="text-align: left;">
                        <?php
                        $skillModel = new JsSkill();
                        Yii::$app->jobPortalModal
                                ->popup(
                                        $skillModel,
                                        "Add skill",
                                        "green",
                                        "plus",
                                        "/js-skill/_form",
                                        "/jobseeker/js-skill/create",
                                        "Add"
                        );
                        ?>		   			

                    </td>
                </tr>
            <?php } ?>

            <tr>
                <th>Skills</th>
                <th>Skills level</th>
                <?php if (Yii::$app->user->can('user')) { ?>
                    <th>Action</th>
                <?php } ?>
            </tr>
            <?php
            $skills = $jobseeker->jsSkills;
            foreach ($skills as $skill) {
                ?>
                <tr>
                    <td><?= isset($skill->skill->skill) ? $skill->skill->skill : "-"; ?></td>
                    <td><?= isset($skill->skillLevel->level) ? $skill->skillLevel->level : "-"; ?></td>
                    <?php if (Yii::$app->user->can('user')) { ?>
                        <td  class="pxp-dashboard-table-options">
                            <a href="#">
                                <?php
                                $skillModel = JsSkill::find()->where(['id' => $skill->id])->one();
                                Yii::$app->jobPortalModal->popup($skillModel, "View skills", "blue", "fa fa-eye", "/js-skill/_view");
                                ?>
                            </a>
                            <?php if (!isset($_GET['js'])) { ?>
                                <a href="#">
                                    <?php
                                    $skillmodel = JsSkill::find()->where(['id' => $skill->id])->one();
                                    Yii::$app->jobPortalModal
                                            ->popup(
                                                    $skillmodel,
                                                    "skill",
                                                    "green",
                                                    "fa fa-edit",
                                                    "/js-skill/_form",
                                                    '/jobseeker/js-skill/update?id=' . $skillmodel->id
                                    );
                                    ?>
                                </a>

                                <a href="#" style="background-color: #e9e9e9"  type="button" value="Cancel" onclick="if (confirm('Are you sure you want to delete ?'))
                                               window.location.href = 'user-profile/removeitem?skillid=<?= $skillModel->id ?>';" /><button class="fa fa-trash-o action-button-danger" aria-hidden="true" ></button>
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
        function hideAndShowSkill() {

            let column = "show_skill";
            let variable = $("#input_skill").val();
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