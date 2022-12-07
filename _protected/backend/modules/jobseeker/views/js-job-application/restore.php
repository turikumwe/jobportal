<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\jobseeker\models\search\JsJobApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Js Job Applications');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<style>
    .modal-dialog {
        position:absolute;
        top:50% !important;
        transform: translate(0, -50%) !important;
        -ms-transform: translate(0, -50%) !important;
        -webkit-transform: translate(0, -50%) !important;
        margin:auto 20%;
        width:60%;
        height:80%;
    }
    .modal-content {
        min-height:100%;
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        right:0; 
    }
    .modal-body {
        position:absolute;
        top:45px; /** height of header **/
        bottom:45px;  /** height of footer **/
        left:0;
        right:0;
        overflow-y:auto;
    }
    .modal-footer {
        position:absolute;
        bottom:0;
        left:0;
        right:0;
    }

</style>
<div class="js-job-application-index">
    <div id="ajaxCrudDatatable">
    <?php Pjax::begin(['id'=>'crud-datatable', 'timeout' => false,'enablePushState' => false,]);?>
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columnsrestore.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-list"></i>', ['index'],
                    ['role'=>'#','title'=> 'Job applications','class'=>'btn btn-default']).
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
                'type' => 'danger', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Js Job Applications listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                '<div class="clearfix"></div>',
            ]
        ])?>
         <?php Pjax::end();?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'options' => [
            'tabindex' => false // important for Select2 to work properly
            ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
