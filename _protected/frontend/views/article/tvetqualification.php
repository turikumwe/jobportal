<?php

use yii\httpclient\Client;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use backend\models\SDistrict;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$client = new Client();
?>
<div class="kora-modal-content">
    <div class="login__wrp">
        <div class="login">
                <strong><?= Yii::t("frontend","Find") ?></strong>
                <hr>
            <!-- <fieldset>
                <legend><span="size: 12px;">Search School</span></legend> -->
                <?php
                $form = ActiveForm::begin([
                    'id' => 'form-register-jobseeker',
                    // 'action' => '/article/find-tvet-qualification-courses'
                ])
                ?>
                <div class="inline__flds">
                    <div class="input__fld">
                        <input type="text" name="qualification" placeholder="Type Qualification Like Carpentry">
                    </div>
                    <div class="input__fld">
                        <?= Html::dropDownList(
                            'district',
                            null,
                            ArrayHelper::map(SDistrict::find()->orderBy('district')->where(['!=', 'province_id', 6])->asArray()->all(), 'district', 'district'),
                            [
                                'id' => 'district_id',
                                'prompt' => Yii::t('frontend', 'Select District'),
                            ]
                        ); ?>
                    </div>
                </div>
                <div class="inline__flds">
                    <div class="input__fld">
                        <select name="school_type">
                            <option value="">Select School Type</option>
                            <option value="Polytechnic">Polytechnic</option>
                            <option value="TVET School">TVET School</option>
                        </select>
                    </div>
                    <div class="input__fld">
                        <select name="school_status">
                            <option value="">Select School Status</option>
                            <option value="Private">Private</option>
                            <option value="Public">Public</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="submit" class="button">Search</button>
                <?php ActiveForm::end(); ?>
            <!-- </fieldset> -->
        </div>
    </div>
</div>
<?php

if ($_POST) {

    $response = $client->createRequest()
        ->setMethod('GET')
        ->setUrl('https://mis.rp.ac.rw/api/schools/alldata')
        ->setHeaders(['content-type' => 'application/json'])
        // ->setData([
        //     'sort' => 'qualification_title',
        // ])
        ->send();

    //Convert json to array
    $data = Json::decode($response->content);

    //Reduce the dimensions of a multidimensional array
    $data = $data['schools'];

    $result = array();
    $result2 = array();
    $result3 = array();

    if (!empty($_POST['qualification'])) {
        foreach ($data as $data) {
            if (stripos(strtolower($data['qualification_title']), strtolower($_POST['qualification'])) !== FALSE) {
                $result[] = $data;
            }
        }
        $data = $result;
    }

    if (!empty($_POST['district'])) {
        foreach ($data as $data) {
            if ($data['district'] == $_POST['district']) {
                $result2[] = $data;
            }
        }
        $data = $result2;
    }

    if (!empty($_POST['school_type'])) {
        foreach ($data as $data) {
            if ($data['school_type'] == $_POST['school_type']) {
                $result3[] = $data;
            }
        }
        $data = $result3;
    }

    if (!empty($_POST['school_status'])) {
        foreach ($data as $data) {
            if ($data['school_status'] == $_POST['school_status']) {
                $result4[] = $data;
            }
        }
        $data = $result4;
    }

    if (COUNT($data) > 0) {
?>
        <h2>Result: <?= COUNT($data) . " Records found" ?></h2>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Qualification</th>
                        <th>School</th>
                        <th>Province</th>
                        <th>District</th>
                        <th>School Type</th>
                        <th>School Status</th>
                        <th>Phone</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $data) { ?>
                    <tr>
                        <td><?= $data['qualification_title'] ?></td>
                        <td><?= $data['school_name'] ?></td>
                        <td><?= $data['province'] ?></td>
                        <td><?= $data['district'] ?></td>
                        <td><?= $data['school_type'] ?></td>
                        <td><?= $data['school_status'] ?></td>
                        <td><?= $data['phone'] ?></td>
                        <td><?= $data['email'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
<?php
    } else {
        echo "No records found";
    }
}
