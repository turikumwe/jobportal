<?php
/**
 * @var $this \yii\web\View
 * @var $url \common\models\User
 */
?>

	<h2>Title:  <b><?= $title ?></b></h2>

	Link : <?php echo Yii::t('common', 'Please click here : {url}', ['url' => Yii::$app->formatter->asUrl($url)]) ?><br>


	<p>Message:  <?= $message?></p>



	<p>Deadline: <?= $closure_date ?> </p>

	From : <?php echo Yii::t('common', '{from}', ['from' => Yii::$app->formatter->asUrl($from)]) ?><br>
