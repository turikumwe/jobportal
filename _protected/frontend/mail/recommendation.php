<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $token string */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/sign-in/recommendation','to_email'=> $to, 'from_id' => $from]);
?>

<p> <?= $recommendation ?> </p>

Follow the link below to recommend your friend on jobport Rwanda:

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
