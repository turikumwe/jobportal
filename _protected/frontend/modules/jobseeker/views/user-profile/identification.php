<div class='well profil'>

    <table class='table table-responsive'> 
        <tr >

            <td colspan='2'> <i class="fa fa-user"></i> Identification  </td>

        </tr>


        <tr>
            <td><?php if (Yii::$app->user->can('mediator')) { ?>
                    <?php if (isset($_GET['js'])) { ?>
                        <?php if ($jobseeker->userProfile->user->status == \common\models\User::STATUS_NOT_ACTIVE) { ?>
                            <div class='pull-right'><?php include('activate.php')
                            ?></div>
                        <?php } ?>
                    <?php } ?>
                    <?php } ?></td><td>
                    <?php if (!Yii::$app->user->can('employer')) { ?>
                        <?php if (!isset($_GET['js'])) { ?>
                            <?php include('editIdentification.php') ?>
                            <?php include('settings.php') ?> 
                            <?php include('terminate.php') ?> 
                        <?php } ?> 



                <?php } ?>
            </td> 
        </tr>
    </table>

    <div class="pxp-single-candidate-side-panel mt-5 mt-lg-0">
        <table class='table table-responsive'>  <tr>
                <td>First Name :

                    <?= $jobseeker->userProfile->firstname; ?></td> 
            </tr>

            <tr>
                <td>Last Name: 

                    <?= $jobseeker->userProfile->lastname; ?></td>
            </tr>

            <tr>
                <td>Gender :

                    <?= ($jobseeker->userProfile->gender == \common\models\UserProfile::GENDER_FEMALE) ? 'Female' : 'Male'; ?>
                </td>
            </tr>

            <tr>
                <td>Martial Status :

                    <?= (isset($jobseeker->userProfile->maritalStatus->status)) ? $jobseeker->userProfile->maritalStatus->status : '*' ?>
                </td>
            </tr>

            <!-- <div class="row">
    <div class="col-sm-6">
            <div class="row mgbt-xs-0">
                    <label class="col-xs-5 control-label">Email:</label>
                    <div class="col-xs-7 controls"> -->
            <?php //echo $jobseeker->email; 
            ?>
            <!-- </div> -->
            <!-- col-sm-10 -->
            <!-- </div>
    </div>
    <div class="col-sm-6">
            <div class="row mgbt-xs-0">
                    <label class="col-xs-5 control-label">Phone:</label>
                    <div class="col-xs-7 controls"> -->
            <?php //echo $jobseeker->userProfile->phone_number 
            ?>
            <!-- </div> -->
            <!-- col-sm-10 -->
            <!-- </div>
    </div>
    </div> -->
            <tr>
                <td>Country :

                    <?= (isset($jobseeker->userProfile->nationality0->cc_description)) ? $jobseeker->userProfile->nationality0->cc_description : '-'; ?>
                </td>
            </tr>
            <tr>
                <td>Birthday :

                    <?= date('M d,Y', strtotime($jobseeker->userProfile->dob)); ?></td>
            </tr>

    </div></div>