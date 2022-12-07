<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
$this->title = "Loan facility";
// $this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Html;
?>
<div class="container"><br>
    <h3>Loan facilities</h3>
    <p>
        With the ‘National Employment Program (NEP) the Government of Rwanda supports the 
        development of employability skills through short-term training courses and 
        entrepreneurship and business development through business advisory services as well as 
        loan facilities and guarantee schemes. <br>
        <strong>Are you planning to become an entrepreneur or did you just form a cooperative? </strong> <br>
        <strong>Here you can find out more details about available support and if you would be eligible:</strong> <br>
    </p>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                    Are you struggling with developing your business plan? You don’t know 
                    how to shape your business idea into a bankable project?</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse in">
                <div class="panel-body">
                    <strong>Proximity Business Advisory Services Scheme </strong> <br>
                    The beneficiary contributes 30% while the Government of Rwanda through 
                    National Employment Program (NEP) contributes 70% of the vouchers’ 
                    value.<br>
                    Eligible candidates: youth, women and people with disabilities<br><br>
                    <strong>Interested?</strong> <br>
                    Contact your BDA in your sector or your nearest Employment Service 
                    Center for more information.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                    You want to start a business and you don’t know how to finance tools and equipment needed?</a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                    <strong>Start-up toolkit Loan Facility</strong><br>
                    An eligible candidate gets from his SACCO 100% funds necessary to cover 
                    the cost of necessary toolkit/equipment to start his small enterprise. <br>
                    50% of the funds constitutes a Government Grant and the remaining is a 
                    SACCO loan to the beneficiary to be paid back according to the signed 
                    terms of a loan contracted. <br>
                    The grant component of the facility will depend on the total cost of the 
                    toolkit/equipment according to the following formulae: The ceiling for an 
                    individual is FRW 500,000 and the ceiling for a cooperative is 
                    RWF 5,000,000.<br>
                    Beneficiaries: Graduates from TVET schools and apprentices or Training 
                    provider accredited by WDA.<br><br>

                    <strong>Could this help you?</strong> <br> 
                    Approach Umurenge SACCO or BDF in your district 
                    for further information, or your nearest Employment Service Center.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                    You are a cooperative operating in an ICPC and you don’t have enough money to buy equipment?
                    </a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <strong>Leasing Scheme to help ICPC Operators to get equipment</strong><br>
                    The scheme was out in place to address the issue of ICPC operators who 
                    used to have difficulties in getting equipment.<br><br>
                    <strong>Is this something for you?</strong><br> 
                    Please contact the BDF in your district or your nearest Employment 
                    Service Center for more information. 
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                        Is your business project lacking sufficient collateral security?
                    </a>
                </h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
                <div class="panel-body">
                    <strong>Guarantee and grant scheme to support youth and women to access finance</strong><br>
                    Women and youth who do have a business idea but without collateral security, collateral security collateral security are provided with guarantee up to 75 percent through BDF.
                    Eligible candidates: Youth, Women and People with Disabilities<br><br>

                    <strong>Could this help you?</strong> <br>
                    Please contact the BDF in your district or your nearest Employment 
                    Service Center for more information.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                    You want to start a business in agriculture and you don’t know how to finance it?
                    </a>
                </h4>
            </div>
            <div id="collapse5" class="panel-collapse collapse">
                <div class="panel-body">
                        <strong>Agribusiness Investment Facility for University graduates</strong><br>
                        The scheme supports the University graduates (A0/A1) having new 
                        projects with less than one year of existence and good agribusiness 
                        idea.<br><br>
                        <strong>KEY FEATURES are:</strong><br>
                        <ul>
                            <li>10% of owner’s contribution in the business,</li>
                            <li>30% of grant in the business, </li>
                            <li>60% converted into shares & debt, </li> 
                            <li>The ceiling for cooperative/companies is    FRW 10,000,000, </li>
                            <li>12 months of grace period, </li>
                            <li>6 months of grace period, </li>
                            <li>5 years of repayment.</li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
</div>