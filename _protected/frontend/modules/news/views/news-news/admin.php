<?php

use frontend\assets\FrontendAsset;
use yii\bootstrap\ActiveForm;
use \yii\widgets\CustomLinkPager;
use common\models\SOccupationGrouping;

;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$bundle = FrontendAsset::register($this);
$this->title = Yii::t('backend', 'Job');
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php
    include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <div class="row">
            <div class="col-md-6">
                <h1>Manage news</h1>
                <span class="pxp-text-light">Detailed list with all posted news.</span>
            </div>
            <div class="col-md-6">
                <span style="float: right;"><a href="<?= Yii::getAlias('@frontendUrl') . '/news/news-news/post-news'; ?>" class="btn rounded-pill pxp-nav-btn">Post news</a></span>
            </div>
        </div>
        <div class="mt-4">
            <div class="row justify-content-between align-content-center">
                <div class="col-auto order-2 order-sm-1">
                    <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                        <select class="form-select" id="status">
                            <option>Bulk actions</option>
                            <option value="1">Publish</option>
                            <option value="2">Unpublish</option>
                        </select>
                        <button class="btn ms-2" onclick="return change_status();">Apply</button>

                    </div>
                </div>
                <div class="col-auto order-1 order-sm-2">
                    <div class="pxp-company-dashboard-jobs-search mb-3">
                        <div class="pxp-company-dashboard-jobs-search-results me-3"><?= $news_count; ?> events</div>
                        <div class="pxp-company-dashboard-jobs-search-search-form">
                            <?php $form = ActiveForm::begin(['id' => 'search_news_title', 'method' => 'GET', 'action' => Yii::$app->link->frontendUrl('/news/news-news/admin')]); ?>
                            <div class="input-group">
                                <span class="input-group-text"><span class="fa fa-search"></span></span>
                                <input type="text" name="title" class="form-control" placeholder="Search news...">
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (count($news) > 0) { ?>
                <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['id' => 'event_list', 'action' => Yii::$app->link->frontendUrl('/news/news-news/bulk-status')]); ?>
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="pxp-is-checkbox" style="width: 1%;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                <th style="width: 40%;">Headline</th>
                                <th style="width: 15%;">Source</th>
                                <th>Category</th>
                                <th>Publication date<span class="fa fa-angle-up ms-3"></span></th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $counter = 1;
                            foreach ($news as $new) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input checkboxAll" name="selected_news[]" value="<?= $new->id; ?>" class="news_selection"></td>
                                    <td>
                                        <a href="<?= $new->link ?>">
                                            <div class="pxp-company-dashboard-job-title"><?= $new->headline; ?></div>

                                            </div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category"><?= ($new->news_type == 1) ? "Kora Job portal" : $new->source; ?></div></td>
                                    <td><div class="pxp-company-dashboard-job-category"><?= ($new->news_type == 1) ? "Internal" : "External"; ?></div></td>
                                    <td><div class="pxp-company-dashboard-job-date mt-1"><?= date_format(date_create($new->publication_date), "M d, Y");?></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-status">
                                            <?php
                                            $job_action = backend\models\SActions::findOne($new->action_id);

                                            if ($new->action_id == 1) {
                                                ?>
                                                <span class="badge rounded-pill bg-success"><?= $job_action['action']; ?></span>
                                                <?php
                                            } else if ($new->action_id == 2) {
                                                ?>
                                                <span class="badge rounded-pill bg-secondary"><?= $job_action['action']; ?></span>
                                                <?php
                                            }
                                            ?>

                                        </div></td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled ">
                                                <li><a href="<?= Yii::$app->link->frontendUrl('/news/news-news/update?id=' . $new->id) ?>"><button title="Edit" type="button" class="action-button"><span class="fa fa-pencil"></span></button></a></li>
                                                <li><a href="<?= Yii::$app->link->frontendUrl('/news/news-news/view?id=' . $new->id) ?>"><button title="Preview" type="button" class="action-button"><span class="fa fa-eye"></span></button></a></li>
                                                <?php $form = ActiveForm::begin(['method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/news/news-news/delete')]); ?>
                                                <input type="hidden" name="id" value="<?= $new->id ?>" />
                                                <li><a href="<?= Yii::$app->link->frontendUrl('/news/news-news/delete?id=' . $new->id) ?>" onclick="return confirm_delete();"><button title="Delete" type="button" class="action-button-danger"><span class="fa fa-trash-o"></span></button></a></li>
                                                <?php ActiveForm::end(); ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>


                        </tbody>
                    </table>
                    <input type="hidden" id="selected_status" name="selected_status" value="" />
                    <?php ActiveForm::end(); ?>
                    <div class="row mt-4 justify-content-between align-items-center">
                        <div class="col-auto">
                            <nav class="mt-3 mt-sm-0" aria-label="Jobs list pagination">
                                <?php
                                echo CustomLinkPager::widget([
                                    'pagination' => $pagination,
                                ]);
                                ?>
                            </nav>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>
<script type="text/javascript">
    $("#selectAll").click(function () {
        $(".checkboxAll").prop('checked', $(this).prop('checked'));
    });
    function change_status() {
        var total_checked = $("input[type='checkbox']:checked").length;

        if (parseInt($('#status :selected').val()) && total_checked > 0) {
            if (confirm("Are sure you want to change the event Status?")) {
                $('#selected_status').val($('#status :selected').val());
                $("#event_list").submit();
            }
        } else {
            alert("Please make valid selections")
        }

    }
    function filter_by_opportunity() {
        if (parseInt($('#opportunity_type :selected').val()) > 0) {
            window.location.href = '<?= Yii::$app->link->frontendUrl('/service/service-event/my-events'); ?>' + '?type=' + $('#opportunity_type :selected').val();
        } else {
            alert("Please make valid selections")
        }

    }
    function search_job() {
        if (parseInt($('#opportunity_type :selected').val()) > 0) {
            window.location.href = '<?= Yii::$app->link->frontendUrl('/service/service-job/my-jobs'); ?>' + '?type=0&' + $('#opportunity_type :selected').val();
        } else {
            alert("Please make valid selections")
        }

    }
    function confirm_delete() {
        if (confirm("Are you sure want to delete this? No undo")) {
            return true;
        } else {
            return false;
        }

    }
</script>

