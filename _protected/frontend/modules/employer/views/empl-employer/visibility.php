<?php if (!isset($_GET['employer'])) { ?>
    <div class="panel widget light-widget panel-bd-top">
        <div class="panel-heading"><?= Yii::t("frontend", "Public can see") ?></div>
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td><b>Summary</b></td>
                    <td>
                        <a href="#" onClick="hideAndShowSummary()" class="mgbt-xs-15 font-semibold pull-right">
                            <input type="checkbox" id="input_summary" value="<?= ($employer->employerProfile->show_employer_summary) ? 0 : 1 ?>" <?= ($employer->employerProfile->show_employer_summary) ? 'checked' : '' ?>>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><b>Address and contact</b></td>
                    <td>
                        <a href="#" onClick="hideAndShowAddress()" class="mgbt-xs-15 font-semibold pull-right">
                            <input type="checkbox" id="input_address" value="<?= ($employer->employerProfile->show_address) ? 0 : 1 ?>" <?= ($employer->employerProfile->show_address) ? 'checked' : '' ?>>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><b>Economic Sector</b></td>
                    <td>
                        <a href="#" onClick="hideAndShowEconomic()" class="mgbt-xs-15 font-semibold pull-right">
                            <input type="checkbox" id="input_economic_sector" value="<?= ($employer->employerProfile->show_economic_sector) ? 0 : 1 ?>" <?= ($employer->employerProfile->show_economic_sector) ? 'checked' : '' ?>>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><b>Status</b></td>
                    <td>
                        <a href="#" onClick="hideAndShowStatus()" class="mgbt-xs-15 font-semibold pull-right">
                            <input type="checkbox" id="input_status" value="<?= ($employer->employerProfile->show_employer_status) ? 0 : 1 ?>" <?= ($employer->employerProfile->show_employer_status) ? 'checked' : '' ?>>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<?php } ?>