<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\mediator\models\search\MdMediatorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Md Mediators');
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
<div class="md-mediator-index">
    <div id="ajaxCrudDatatable">
        <?php Pjax::begin(['id'=>'crud-datatable', 'timeout' => false,'enablePushState' => false,]);?>
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['md-mediator/create-public-mediator'],
                    [
                        // 'role'=>'modal-remote',
                        'title'=> 'Create new mediator',
                        'class'=>'btn btn-default'
                    ]).
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', ['deleted'],
                    ['role'=>'#','title'=> 'Deleted mediators','class'=>'btn btn-default']).
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
                'type' => 'success', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Md Mediators listing',
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
<?php $form = ActiveForm::begin(['id' => 'change_mediator_status', 'method' => 'POST', 'action' => Url::to(['/mediator/md-mediator/status'])]); ?>
<input type="hidden" name="mediator_id" id="selected_mediator_id">
<input type="hidden" name="action" id="action">
<?php ActiveForm::end(); ?>
<script type="text/javascript">
    function confirm_action(id, action) {
        if (confirm("Are you sure you want to perfom this action?")) {
            $('#selected_mediator_id').val(id);
            $('#action').val(action);
            $('#change_mediator_status').submit();
        }
        return false;
    }
</script>
