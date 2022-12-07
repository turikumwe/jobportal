<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var $model common\models\TimelineEvent
 */
use Yii\helpers\Html;

?>
<div class="timeline-item" style="background-color: #ecf0f5">
    <span class="time">
        <i class="fa fa-clock-o"></i>
        <?php echo Yii::$app->formatter->asRelativeTime($model->created_on) ?>
    </span>
    <h3 class="timeline-header">
        <?php echo "&nbsp;" ?>
    </h3>

    <div class="timeline-body">
        <dl>
            <dd><?php echo Html::a($model->headline,$model->link,['target' => '_blank','style' => 'color: #458cfe;padding: 0px; font-size: 17px;']) ?></dd>
            <dd><?php echo '<b>Source</b>: '.$model->source.', <br><b>Publication date</b>: '.Yii::$app->formatter->asDatetime($model->created_on) ?></dd>
        </dl>
    </div>
</div>