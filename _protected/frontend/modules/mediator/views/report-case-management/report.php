<?php
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset; 

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\jobseeker\models\search\JsCaseManagement */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Report');
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
            <?php include('menu/index.php');?>
        </div>

        <div class="col-sm-10">
            
            <p>
                <span>
                    <?= Html::a(Yii::t('app', 'Advanced Search'), '#', ['class' => 'btn btn-success search-button']) ?>
                </span>
            </p>
            
            <div class="panel widget light-widget panel-bd-top" >
                <div class="panel-heading no-title" style="height: 20px"> </div>
                    <div class="panel-body">
                        <div class="js-case-management-index">
                            <div id="ajaxCrudDatatable">
                                <?php echo $content ?>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>