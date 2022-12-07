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
    if (Yii::$app->user->can('mediator')) {
        include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    } else if (Yii::$app->user->can('employer')) {
        include(Yii::$app->getModule('employer')->basePath . "/views/layouts/admin_navigation.php");
    } else if (Yii::$app->user->can('RDB')) {
        include(Yii::$app->getModule('mediator')->basePath . "/views/layouts/admin_navigation.php");
    } else {
        include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_navigation.php");
    }
    ?>
</div>
<div class="pxp-dashboard-content">

    <?php include(Yii::$app->getModule('jobseeker')->basePath . "/views/layouts/seeker_top_header.php") ?>
    <div class="pxp-dashboard-content-details">
        <h1>Notifications</h1>
        <p class="pxp-text-light">History of all your received notifications.</p>

        <div class="mt-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Received on</th>
                    </thead>
                    <tbody>
                        <?php
                        if (count($notifications) > 0) {
                            $counter = 1;
                            foreach ($notifications as $notification) {
                                ?>
                                <tr>
                                    <td style="vertical-align: top;"><?= $counter ?></td>
                                    <td style="width: 25%;vertical-align: top;">
                                        <?= $notification->message_title; ?>
                                    </td>
                                    <td style="width: 65%;">
                                        <?= $notification->message_body; ?>
                                    </td>
                                    <td><div class="pxp-dashboard-notifications-item-right"><?= date_format(date_create($notification->created_at), "M d, Y H:i:s") ?></div></td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <?php if ($notification->is_opened == 0) { ?>
                                                <?php $form = ActiveForm::begin(['id' => 'notification_' . $notification->id, 'method' => 'POST', 'action' => Yii::$app->link->frontendUrl('/user/profile/open-notification')]); ?>
                                                <ul class="list-unstyled">
                                                    <li><button title="<?= ($notification->is_opened == 1) ? 'Notification opened' : 'Mark as read'; ?>" class="action-button" type="button" onclick="this.form.submit()"><span class="fa fa-envelope-<?= ($notification->is_opened == 1) ? 'open' : 'o'; ?>"></span></button></li>
                                                </ul>
                                                <input type="hidden" value="<?= $notification->id; ?>" name="notification_id" id="not_<?= $notification->id; ?>" />
                                                <?php ActiveForm::end(); ?>
                                            <?php } else { ?>
                                                <ul class="list-unstyled">
                                                    <li><button title="Notification opened" class="action-button"><span class="fa fa-envelope-open"></span></button></li>
                                                </ul>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $counter++;
                            }
                        }
                        ?>

                    </tbody>
                </table>

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
        </div>
    </div>
    <?php include(Yii::$app->basePath . "/views/layouts/user_footer.php") ?>
</div>

