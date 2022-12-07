<?php

use common\models\JsLanguage;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>

<div class="row profile">
    <div  class="col-sm-12">


        <div id="language" class="content-list content-menu responsive">
            <table class='table table-bordered table-striped'>
                <?php if (!isset($_GET['js'])) { ?>
                    <tr>
                        <td colspan="6" style="text-align: left;">
                            <?php
                            $languageModel = new JsLanguage();
                            Yii::$app->jobPortalModal
                                    ->popup(
                                            $languageModel,
                                            "Add language",
                                            "green",
                                            "fa fa-plus",
                                            "/js-language/_form",
                                            "/jobseeker/js-language/create",
                                            "Add"
                            );
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Language</th>
                    <th>Reading</th>
                    <th>Writing</th>
                    <th>Listening</th>
                    <th>Speaking</th>
                    <?php if (Yii::$app->user->can('user')) { ?>
                        <th>Action</th>
                    <?php } ?>
                </tr>
                <?php
                $languages = $jobseeker->jsLanguages;
                foreach ($languages as $language) {
                    ?>
                    <tr>
                        <td><?= isset($language->language0->language) ? $language->language0->language : "-"; ?></td>
                        <td><?= isset($language->reading0->languagerate) ? $language->reading0->languagerate : "-"; ?></td>               
                        <td><?= isset($language->writing0->languagerate) ? $language->writing0->languagerate : "-"; ?></td>
                        <td><?= isset($language->listening0->languagerate) ? $language->listening0->languagerate : "-"; ?></td>
                        <td><?= isset($language->speaking0->languagerate) ? $language->speaking0->languagerate : "-"; ?></td>
                        <?php if (Yii::$app->user->can('user')) { ?>
                            <td class="pxp-dashboard-table-options">
                                <a href="#">
                                    <?php
                                    $languageModel = JsLanguage::find()->where(['id' => $language->id])->one();
                                    Yii::$app->jobPortalModal->popup($languageModel, "View language", "blue", "fa fa-eye", "/js-language/_view");
                                    ?>	
                                </a>
                                <?php if (!isset($_GET['js'])) { ?>
                                    <a href="#">
                                        <?php
                                        $languageModel = JsLanguage::find()->where(['id' => $language->id])->one();
                                        Yii::$app->jobPortalModal
                                                ->popup(
                                                        $languageModel,
                                                        "language",
                                                        "green",
                                                        "fa fa-pencil",
                                                        "/js-language/_form",
                                                        '/jobseeker/js-language/update?id=' . $languageModel->id
                                        );
                                        ?>	
                                    </a>
                                    <a href="#" style="background-color: #e9e9e9"type="button" value="Cancel" onclick="if (confirm('Are you sure you want to delete ?'))
                                                            window.location.href = 'removeitem?languageid=<?= $languageModel->id ?>';" /><button class="fa fa-trash-o action-button-danger" aria-hidden="true" ></button>
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
    function hideAndShowLangage() {

        let column = "show_language";
        let variable = $("#input_language").val();
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