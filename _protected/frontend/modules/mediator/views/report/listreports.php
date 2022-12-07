<div class="pxp-dashboard-side-panel d-none d-lg-block">
    <?php
    if (Yii::$app->user->can('mediator')) {
        include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    } else {
        include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_navigation.php");
    }
    ?>
</div>
<div class="pxp-dashboard-content">
    <?php include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_top_header.php") ?>

    <div class="pxp-dashboard-content-details">
        <h1>Reports</h1>
        <div class="row mt-4">
            <div class="col-xl-12">
                <h2>Detailed reports</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 25%;">Report name</th>
                                <th style="width: 25%;">Descripion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($reports) > 0) {
                                $counter = 1;

                                foreach ($reports as $report) {
                                    $report_access = explode(',', $report->access_user_groups);
                                    
                                    $intersect = array_intersect($user_roles, $report_access);
                                    if (count($intersect) > 0) {
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="pxp-company-dashboard-subscriptions-plan"><?= $counter; ?></div>
                                            </td>
                                            <td><a href="<?= Yii::getAlias('@frontendUrl') . $report->report_url; ?>">
                                                    <div class="pxp-company-dashboard-job-title"><?= $report->report_title; ?></div>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="pxp-company-dashboard-subscriptions-status">
                                                    <div class="pxp-company-dashboard-job-category"><?= $report->report_description; ?></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $counter++;
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="mt-4">

        </div>
    </div>
</div>
