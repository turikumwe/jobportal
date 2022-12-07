<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var $model common\models\TimelineEvent
 */
use Yii\helpers\Html;
use yii\bootstrap\Modal;

?>
<div class="timeline-item" style="background-color: #ecf0f5">
    <span class="time">
        <i class="fa fa-clock-o"></i>
        <?php echo Yii::$app->formatter->asRelativeTime($model->created_on) ?>
    </span>
    <h3 class="timeline-header">
        <?= Html::a('Update',['update','id'=>$model->id],['class' => 'btn btn-link', 'data-pjax' => '0']).' '.
            Html::a('Delete',['/news/news-news/delete','id' => $model->id],
            [
                'class' => 'btn btn-link', 
                'role'=>'modal-remote',
                'title'=>'Delete', 
                'data-confirm'=>false, 
                'data-method'=>false,// for overide yii data api
                'data-request-method'=>'post',
                'data-toggle'=>'tooltip',
                'data-confirm-title'=>'Are you sure?',
                'data-confirm-message'=>'Are you sure want to delete this item'
            ])?>
    </h3>

    <div class="timeline-body">
        <dl>
            <dd><?php echo Html::a($model->headline,$model->link,['target' => '_blank', 'class' => 'btn btn-link','style' => 'padding: 0px; font-size: 17px;']) ?></dd>
            <dd><?php echo '<b>Source</b>: '.$model->source.', <br><b>Publication date</b>: '.Yii::$app->formatter->asDatetime($model->created_on) ?></dd>
        </dl>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>