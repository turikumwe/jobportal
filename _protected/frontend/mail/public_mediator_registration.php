<?php
/**
 * @var $this \yii\web\View
 * @var $url \common\models\User
 */
?>
<?php echo Yii::t('backend', 'Please click here : {url}', ['url' => Yii::$app->formatter->asUrl($url)]) ?><br>

Username: <?= $username?><br>
Password: <?= $password?>
