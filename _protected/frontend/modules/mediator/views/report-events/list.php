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

<div class="well search-form" style="display:none"> 
    <?=  $this->render('_search', ['model' => $searchModel]); ?> 
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
            'columns' => require(__DIR__.'/'.$type.'/_list.php'),
            'toolbar'=> [
                ['content'=>
                    '{toggleData}'.
                    '{export}'
                ],
            ],
            'pager' => [

            'class' => 'yii\widgets\CustomLinkPager',

            //other pager config if nesessary

        ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => '',
                'heading' => '<font color="#000000">Event Report <a href="'.Yii::getAlias('@frontendUrl') . '/mediator/report-events/export-data'.'"><i class="fa fa-file-excel-o"> Export</i>',
             
                // 'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
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
