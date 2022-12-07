
<?php

use common\models\SOccupationGrouping;
?>
<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_navigation.php") ?>


</div>
<div class="pxp-dashboard-content">
    <?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_top_header.php") ?>

    <div class="pxp-dashboard-content-details">
        <h1>Favourites Job Lists</h1>

        <div class="mt-4 mt-lg-5">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th >Job</th>
                            <th>Posted by</th>
                            <th>Category</th>

                            <th>Posted on</th>
                            <th>Closure Date </th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>

                        </tr></thead>

                    <?php
                    foreach ($jobresult as $jobz) {
                        ?>
                        <tr>

                            <td><a href="../../service/service-job/view?id=<?= $jobz['id']; ?>" > <?= $jobz['jobtitle']; ?></a></td>
                            <td><?php
                                $employer = common\models\EmplEmployer::findone($jobz['employer']);
                                if (isset($employer)) {
                                    echo $employer->company_name;
                                } else {
                                    echo $jobz['employer'];
                                }
                                ?>
                            </td>
                            <td><?php $occup = SOccupationGrouping::findOne($jobz['occupation_grouping_id']); ?><?= (isset($occup->occupation_grouping)) ? $occup->occupation_grouping : ''; ?></td>

                            <td>
                                <div class="pxp-company-dashboard-job-date"><?= (isset($jobz['posting_date'])) ? $jobz['posting_date'] : ''; ?></div>
                            </td>
                            <td>
                                <div class="pxp-company-dashboard-job-date"><?= (isset($jobz['closure_date'])) ? $jobz['closure_date'] : ''; ?>
                                </div>
                            </td>
                            <td class="pxp-dashboard-table-options"><?php if (Yii::$app->user->can('user')) { ?>

                                    <a title="View Job Details" href="<?= Yii::getAlias('@frontendUrl') . '/service/service-job/view?id=' . $jobz['id']; ?>"    ><button title="Preview" type="button" class="action-button"><span class="fa fa-eye"></span></button></i>
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="pxp-dashboard-table-options"><?php if (Yii::$app->user->can('user')) { ?> 
                                    <a title="Remove Job from List" href="#"   type="button" value="Cancel" onclick="if (confirm('Are you sure you want to delete ?'))
                                                        window.location.href = 'removeitem?favid=<?= $jobz['id'] ?>';" /><button class="fa fa-trash-o action-button-danger" aria-hidden="true" ></button>
                                    </a><?php } ?></td>

                        </tr>              
                    <?php } ?>
                </table>
            </div></div></div>
