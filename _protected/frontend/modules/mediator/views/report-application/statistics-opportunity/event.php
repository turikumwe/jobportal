<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'User Profiles');
$this->params['breadcrumbs'][] = $this->title;

$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(10); 
    return false; 
});"; 

$this->registerJs($search); 

CrudAsset::register($this);

?>
<style>
    .size {
    height:80px;
    margin-right: auto;
}
</style>
<div class="container">
    <div class="row">
        <?php if (isset($_GET['opportunity'])){ ?>
        <?= Yii::$app->reports->eventStatus($_GET['opportunity']);?>
        <?php } ?>
    </div>
</div>

<div class="well search-form" style="display:none"> 
    <?=  $this->render('_searchEvent', ['model' => $searchModel]); ?> 
</div>

<div class="user-profile-index">
    <div id="ajaxCrudDatatable">
        <?php Pjax::begin(['id'=>'crud-datatable', 'timeout' => false,'enablePushState' => false,]);?>
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>false,
            //'showFooter' => true,
            'showPageSummary' => true,
            'striped' => false,
            'hover' => true,
            'panel' => ['type' => 'primary', 'heading' => 'Grid Grouping Example'],
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'columns' => require(__DIR__.'/_event.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => '', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Event Report',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                 '<div class="clearfix"></div>',
            ]
        ])?>
        <?php Pjax::end();?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
