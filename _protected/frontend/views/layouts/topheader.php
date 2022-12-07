<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
$this->registerJsFile('https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');

?>
<a class="skip-main" href="#main">Skip to main content</a>
<div class="kora-container topheader">
    <div class="pull-left" style="margin-left: 10px;">
        <?= Html::a('Kinyarwanda', ['/site/language', 'id' => 'kn'], ['title' => 'Change the site content in Kinyarwanda', 'tabindex' => 1, 'accesskey' => 'k']) ?> |
        <?= Html::a('English', ['/site/language', 'id' => 'en'], ['title' => 'Change the site content in English', 'tabindex' => 2, 'accesskey' => 'e']) ?>
    </div>
    <div class="pull-right">
        <?php
        if (Yii::$app->user->isGuest) {
            echo Html::a('Create account', Yii::getAlias('@frontendUrl') . '/site/createaccount', ['title' => 'This link will take you to the page where different accounts can be created', 'accesskey' => 'c']) . ' | ';
            echo Html::a(Yii::t('frontend', 'Login'), Yii::getAlias('@frontendUrl') . '/user/sign-in/login', ['data-toggle' => "modal", 'data-target' => "#login", 'title' => 'Go to login page', 'accesskey' => 'l']);
        }
        if (!Yii::$app->user->isGuest) {
            echo '<span style = "font-size: 12px;">';
            echo Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->username;
            echo '</span>';
            if (Yii::$app->user->can('user') && !Yii::$app->user->can('administrator'))
                echo ' | ' . Html::a(Yii::t('frontend', 'Profile'), Url::to(['/jobseeker/user-profile']), ['data-method' => 'post']);
            if (Yii::$app->user->can('employer'))
                echo ' | ' . Html::a(Yii::t('frontend', 'Profile'), Url::to(['/employer/empl-employer/']), ['data-method' => 'post']);
                echo ' | ' . Html::a(Yii::t('frontend', 'Logout'), Url::to(['/user/sign-in/logout']), ['data-method' => 'POST', 'accesskey' => 'g']);
        }
        if (Yii::$app->user->can('manager')) {
            echo ' | ' . Html::a(Yii::t('frontend', 'Backend'), Yii::getAlias('@web/backend'));
        }
        ?>

    </div>
</div>