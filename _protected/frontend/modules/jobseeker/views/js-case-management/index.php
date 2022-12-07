<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\jobseeker\models\search\JsCaseManagement */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Js Case Managements');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<style>
    
    .tabs .nav-tabs{
        background-color: #3c8dbc;
        border-bottom:none;
    }

    .panel-bd-top {
        border-top:3px solid #3c8dbc;
    }
    
</style>
</style>
<div class="vd_content-section clearfix">
        <div class='row'>
        <div class="col-sm-2">
            <?php 
                if(Yii::$app->user->can('mediator')) { 
                    //TODO mediator profile
                } elseif(Yii::$app->user->can('employer')) { 
                    //TODO employer profile
                } else { 
                    echo Yii::$app->jobSeeker->profile($profile);   
                } 
                echo Yii::$app->jobSeeker->menu();
              
                
            ?>

            <div class="panel widget light-widget panel-bd-top">
            <div class="panel-heading no-title"> <h3><center>Case Mgmt</center></h3> </div>
            <div class="panel-body">
                <ul>
                    <li><a href="/jobseeker/js-job-application/case-management">Type A</a></li>
                    <li><a href="/jobseeker/js-event-application/case-management">Type B</a></li>
                </ul>
            </div>
        </div>

        </div>

        <div class="col-sm-10">
            <div class="panel widget light-widget panel-bd-top" >
                <div class="panel-heading no-title" style="height: 20px"> </div>
                    <div class="panel-body">
                        <div class="js-case-management-index">
                            <div id="ajaxCrudDatatable">
                                <?=GridView::widget([
                                    'id'=>'crud-datatable',
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'pjax'=>true,
                                    'columns' => require(__DIR__.'/_columns.php'),
                                    'toolbar'=> [
                                        ['content'=>
                                            // Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                                            // ['role'=>'modal-remote','title'=> 'Create new Js Case Managements','class'=>'btn btn-default']).
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
                                        'type' => 'primary', 
                                        'heading' => '<i class="glyphicon glyphicon-list"></i> Js Case Managements listing',
                                        'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                                        '<div class="clearfix"></div>',
                                    ]
                                ])?>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
