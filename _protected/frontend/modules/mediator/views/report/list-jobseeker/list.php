<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'User Report');
$this->params['breadcrumbs'][] = $this->title;
 
CrudAsset::register($this);
?>
<div class="well">

<table class="table">
    <thead>
        <th colspan="2"><center><h3>Report</h3></center></th>
    </thead>
    <tbody>
    <tr>
        <td>Number of user</td>
        <td><?= $dataProvider->getCount()?></td>
    </tr>
    </tbody>
    
</table>
</div>
<div class="user-Report-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>false,
            'showFooter' => true,
            'showPageSummary' => false,
            'columns' => require(__DIR__.'/_list.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
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
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> User Profiles listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                 '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
