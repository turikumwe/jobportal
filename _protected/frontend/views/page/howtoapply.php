<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
$this->title = "How to Apply";
// $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Html;
?>
<style>
    body {
    position: relative; 
    }
    #section1 {padding:10px;height:200px;color: #fff; background-color: #1E88E5;}
    #section2 {padding:10px;height:300px;color: #fff; background-color: #673ab7;}
    #section3 {padding:10px;height:200px;color: #fff; background-color: #ff9800;}
    #section41 {padding:10px;height:200px;color: #fff; background-color: #00bcd4;}
    #section42 {padding:10px;height:200px;color: #fff; background-color: #009688;}
</style>
<div class="container">
    <?php //echo $model->body; ?>
    <div class="row">
        <div class="col-md-3 clpadding">
            <div id="displayAll" class="panel widget light-widget panel-bd-top">
                <div class="panel-heading">
                    <a href="#">
                        <?php echo Yii::t("frontend", "How to Apply"); ?>
                    </a>
                </div>
                <div class="panel-body tags" id="district" style="display:block">
                    <table class="table table-condensed">
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                    <?php echo $model->title ?>
                                </a>
                            </td>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                    How to write a CV?
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                    How to write a cover letter?
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                    Preparing for interviews
                                </a>
                            </td>
                        </a>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                                    Why someone should do application management?
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                                    Internship as an entry point
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tabs widget">
                <ul class="nav nav-tabs widget" style="color: #fff;">
                    <li>&nbsp;</li>
                    <li style="border-right: 0px"><?php echo Yii::t("frontend", "How to Apply"); ?></li>
                </ul>
            </div>
            <div class="panel-group" id="accordion">
                <div class="panel panel-default noborder">
                    <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">
                    <p>
                        <div class="row">
                            <div class="col-md-9">
                                <h3><?php echo Yii::t("frontend", $model->title); ?></h3>
                                <p><?php echo Yii::t("frontend", $model->body); ?></p>
                            </div>
                            <div class="col-md-3"><br>
                                <div style="padding: 10px 10px; background-color: #f5f5f5">
                                    <b>Links</b><br><br>
                                    <?= Html::a('<span class="glyphicon glyphicon-file"></span>11 tips for job search', ['/storage/howtoapply/TipsforaSuccessfulJobSearchStrategies.pdf','opportunity'=>3])?><br>&nbsp;
                                </div>
                            </div>
                        </div>
                    </p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>