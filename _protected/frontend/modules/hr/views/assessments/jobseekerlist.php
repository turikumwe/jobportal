<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'User Profiles');
$this->params['breadcrumbs'][] = $this->title;

$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(1000); 
    return false; 
});";
$this->registerJs($search);

CrudAsset::register($this);

?>

<div class="kora-container vd_content-section clearfix">
    <div class='row'>
        <!-- <div class="col-sm-3"> -->
        <?php /*echo Yii::$app->jobSeeker->menu(); */ ?>
        <!-- </div> -->

        <div class="col-sm-12">
            <p>
                <span>
                    <?= Html::a(Yii::t('app', 'Advanced Search'), '#', ['class' => 'btn btn-success search-button']) ?>
                </span>

                <!-- <span class="pull-right"> -->
                <?php /*echo Html::a(Yii::t('app', 'Register new Job Seeker'), 'register', ['class' => 'btn btn-primary']) */ ?>
                <!-- </span>  -->
            </p>

            <div class="well search-form" style="display:none">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>

            <div class="panel widget light-widget panel-bd-top">
                <!-- <div class="panel-heading"> Jobseeker Report</div> -->
                <div class="panel-body">
                    <div class="user-profile-index">
                        <div id="ajaxCrudDatatable">
                            <?php Pjax::begin(['id' => 'crud-datatable', 'timeout' => false, 'enablePushState' => false,]); ?>
                            <?= GridView::widget([
                                'id' => 'crud-datatable',
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'pjax' => true,
                                'showPageSummary' => false,
                                'striped' => false,
                                'hover' => true,
                                'panel' => ['type' => 'primary', 'heading' => 'Jobseeker list'],
                                'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                                'columns' => require(__DIR__ . '/_jobseekerlist.php'),
                                'toolbar' => [
                                    [
                                        'content' =>
                                        '{toggleData}' .
                                            '{export}'
                                    ],
                                ],
                                'striped' => true,
                                'condensed' => true,
                                'responsive' => true,
                                'panel' => [
                                    'type' => '',
                                ]
                            ]) ?>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>