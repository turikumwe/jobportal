<div class="panel widget light-widget">
    <div class="panel-heading"><?= Yii::t("frontend", "Actions") ?></div>
    <div class="panel-body">
        <table class="table">
            <tr>
                <th>Jobportal Form</th>
                <td>
                    <?php
                    echo '<a href="' . Yii::$app->link->frontendUrl('/service/service-job/post-opportunity') . '" class="btn btn-success">Post</a>';
                    ?>
                </td>
            </tr>
            <tr>
                <th>From Other Source Form</th>
                <td>
                    <?php
                    echo '<a href="' . Yii::$app->link->frontendUrl('/service/service-job/post-opportunity-from-other-source') . '" class="btn btn-success">Post</a>';
                    ?>
                </td>
            </tr>
            <tr>
                <th>Training</th>
                <td>
                    <?php
                    echo '<a href="' . Yii::$app->link->frontendUrl("/service/service-event/post-opportunity") . '" class="btn">Post</a>';
                    ?>
                </td>
            </tr>
        </table>
    </div>
</div>