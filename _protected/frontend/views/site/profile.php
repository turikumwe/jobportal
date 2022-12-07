<?php include(Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'header.php') ?>
<section>
    <div class="pxp-container">
        <div class="pxp-single-candidate-container">
            <div class="row justify-content-center">
                <div class="col-xl-9">
                    <div class="pxp-single-candidate-hero pxp-cover pxp-boxed" style="background-image: url(images/ph-big.jpg);">
                        <div class="pxp-hero-opacity"></div>
                        <div class="pxp-single-candidate-hero-caption">
                            <div class="pxp-single-candidate-hero-content d-block text-center">
                                <div class="pxp-single-candidate-hero-avatar d-inline-block" style="background-image: url(images/pro.jpg);"></div>
                                <div class="pxp-single-candidate-hero-name ms-0 mt-3">
                                    <h1><?php $fname = common\models\UserProfile::findOne($userid); ?>
                                        <?= (isset($fname->firstname)) ? $fname->firstname : ''; ?>
                                        <?php $lname = common\models\UserProfile::findOne($userid); ?>
                                        <?= (isset($lname->lastname)) ? $lname->lastname : ''; ?>
                                    </h1>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-7 col-xxl-8">
                            <div class="pxp-single-candidate-content">
                                <h2>About <?php $fname = common\models\UserProfile::findOne($userid); ?>
                                    <?= (isset($fname->firstname)) ? $fname->firstname : ''; ?></h2>


                                <?php
                                foreach ($summary as $summ) {
                                    ?>
                                    <p> <?= (isset($summ['professional_profile'])) ? $summ['professional_profile'] : ''; ?> </p> 

                                <?php } ?>

                                <div class="mt-4">
                                    <h2>Skills</h2>
                                    <div class="pxp-single-candidate-skills">
                                        <table><tr>
                                            <ul class="list-unstyled">
                                                <?php foreach ($skills as $skill) { ?>
                                                    <li><?= (isset($skill['skill'])) ? $skill['skill'] : ''; ?>(<?= (isset($skill['level'])) ? $skill['level'] : ''; ?>)


                                                    </li>
                                                <?php } ?>
                                            </ul></tr></table>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h2>Work Experience</h2>
                                    <div class="pxp-single-candidate-timeline">
                                        <?php foreach ($experience as $exper) {
                                            ?>
                                            <div class="pxp-single-candidate-timeline-item">
                                                <div class="pxp-single-candidate-timeline-dot"></div>
                                                <div class="pxp-single-candidate-timeline-info ms-3">
                                                    <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'><?= (isset($exper['start_date'])) ? $exper['start_date'] : ''; ?> - <?= (isset($exper['end_date'])) ? $exper['end_date'] : ''; ?> </span></div>




                                                    <div class="pxp-single-candidate-timeline-position mt-2"> <?= (isset($exper['company'])) ? $exper['company'] : ''; ?></div>

                                                    <div class="pxp-single-candidate-timeline-about mt-2 pb-4"><?= (isset($exper['occupation'])) ? $exper['occupation'] : ''; ?> </div>
                                                </div>
                                            </div>

                                        <?php } ?> 

                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h2>Education  </h2>
                                    <div class="pxp-single-candidate-timeline">
                                        <?php foreach ($education as $jseducation) {
                                            ?>
                                            <div class="pxp-single-candidate-timeline-item">
                                                <div class="pxp-single-candidate-timeline-dot"></div>
                                                <div class="pxp-single-candidate-timeline-info ms-3">
                                                    <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'><?= (isset($jseducation['start_date'])) ? $jseducation['start_date'] : ''; ?> - <?= (isset($jseducation['end_date'])) ? $jseducation['end_date'] : ''; ?> </span>
                                                    </div> 
                                                    <div class="pxp-single-candidate-timeline-position mt-2"> <?= (isset($jseducation['field'])) ? $jseducation['field'] : ''; ?></div>
                                                    <div class="pxp-single-candidate-timeline-about mt-2 pb-4"> <?= (isset($jseducation['school'])) ? $jseducation['school'] : ''; ?></div>

                                                    <div class="pxp-single-candidate-timeline-about mt-2 pb-4"><?= (isset($jseducation['exact_quali'])) ? $jseducation['exact_quali'] : ''; ?> </div>
                                                </div>
                                            </div>

                                        <?php } ?> 

                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h2>Trainings  </h2>
                                    <div class="pxp-single-candidate-timeline">
                                        <?php
                                        foreach ($trainings as $train) {
                                            ?>
                                            <div class="pxp-single-candidate-timeline-item">
                                                <div class="pxp-single-candidate-timeline-dot"></div>
                                                <div class="pxp-single-candidate-timeline-info ms-3">
                                                    <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'><?= (isset($train['start_date'])) ? $train['start_date'] : ''; ?> - <?= (isset($train['end_date'])) ? $train['end_date'] : ''; ?> </span>
                                                    </div> 
                                                    <div class="pxp-single-candidate-timeline-position mt-2"> <?= (isset($train['training_title'])) ? $train['training_title'] : ''; ?></div>
                                                    <div class="pxp-single-candidate-timeline-about mt-2 pb-4"> <?= (isset($train['training_center'])) ? $train['training_center'] : ''; ?></div>

                                                </div>
                                            </div>

                                        <?php } ?> 

                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h2>Languages  </h2>
                                    <div class="pxp-single-candidate-timeline">
                                        <?php
                                        $language = common\models\JsLanguage::find()->where(['user_id' => $userid])->all();
                                        foreach ($language as $langues) {
                                            ?>
                                            <div class="pxp-single-candidate-timeline-item">
                                                <div class="pxp-single-candidate-timeline-dot"></div>
                                                <div class="pxp-single-candidate-timeline-info ms-3">
                                                    <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'><?= \backend\models\SLanguage::findOne($langues['language'])->language; ?> </span>


                                                    </div> 
                                                    <div class="pxp-single-candidate-timeline-about mt-2 pb-4"><ul class="list-unstyled"> <li>Reading <span class="badge rounded-pill bg-success"><?= \backend\models\SLanguageRating::findOne($langues['reading'])->languagerate; ?></span></li>
                                                            <li>Writing <span class="badge rounded-pill bg-success"><?= \backend\models\SLanguageRating::findOne($langues['writing'])->languagerate; ?></span></li>
                                                            <li>Listening <span class="badge rounded-pill bg-success"><?= \backend\models\SLanguageRating::findOne($langues['listening'])->languagerate; ?></span></li>
                                                            <li>Speaking <span class="badge rounded-pill bg-success"><?= \backend\models\SLanguageRating::findOne($langues['speaking'])->languagerate; ?></span></li>
                                                        </ul></div>

                                                </div>
                                            </div>

                                        <?php } ?> 

                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h2>Endorsement  </h2>
                                    <div class="pxp-single-candidate-timeline">
                                        <?php
                                        foreach ($Endorse as $endorsement) {
                                            ?>
                                            <div class="pxp-single-candidate-timeline-item">
                                                <div class="pxp-single-candidate-timeline-dot"></div>
                                                <div class="pxp-single-candidate-timeline-info ms-3">
                                                    <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'>Skill : <?php $skillendor = backend\models\SSkill::findOne($endorsement['skill_id']); ?><?= (isset($skillendor->skill)) ? $skillendor->skill : ''; ?> </span>
                                                    </div> 
                                                    <div class="pxp-single-candidate-timeline-position mt-2"> Endorsed by: <?php $whoendo = mdm\admin\models\searchs\User::findOne($endorsement['who_endorsed_id']); ?><?= (isset($whoendo->username)) ? $whoendo->username : ''; ?></div>


                                                </div>
                                            </div>

                                        <?php } ?> 

                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h2>Recommendation</h2>

                                    <?php
                                    foreach ($recommendation as $recommended) {
                                        ?>
                                        <div class="pxp-single-candidate-timeline-item">
                                            <div class="pxp-single-candidate-timeline-dot"></div>
                                            <div class="pxp-single-candidate-timeline-info ms-3">
                                                <div class="pxp-single-candidate-timeline-time"><span class="me-3" style='width: 200px;'>Recommended by : <?php $recomm = mdm\admin\models\searchs\User::findOne($recommended['who_recommended_id']); ?><?= (isset($recomm['username'])) ? $recomm['username'] : ''; ?>  </span>
                                                </div> 
                                                <div class="pxp-single-candidate-timeline-position mt-2"> Recommendation: <?= (isset($recommended->recommendation)) ? $recommended->recommendation : ''; ?></div>


                                            </div>
                                        </div><?php } ?>
                                    </table> 


                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xxl-4">
                            <div class="pxp-single-candidate-side-panel mt-5 mt-lg-0">
                                <table class='table table-responsive'>  
                                    <tr>
                                        <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Names</div> <?php $fname = common\models\UserProfile::findOne($userid); ?>
                                            <?= (isset($fname->firstname)) ? $fname->firstname : ''; ?>
                                            <?php $lname = common\models\UserProfile::findOne($userid); ?>
                                            <?= (isset($lname->lastname)) ? $lname->lastname : ''; ?> </td>
                                    </tr>
                                    <tr>
                                        <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Email </div><?php $email = common\models\User::findone($userid) ?> <?= (isset($email->email)) ? $email->email : ''; ?></td>

                                    </tr>
                                    <tr>
                                        <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Phone </div><?php $phone = common\models\User::findone($userid) ?><?= (isset($phone->phone)) ? $phone->phone : ''; ?></td></tr>
                                    <tr>
                                        <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Gender </div><?php
                                            $gender = \common\models\UserProfile::findOne($userid)->gender;
                                            $ge = common\models\SGender::findone($gender);
                                            ?><?= (isset($ge->gender)) ? $ge->gender : ''; ?> </td>

                                    </tr>
                                    <tr>
                                        <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Martial Status </div><?php
                                            $mstatus = \common\models\UserProfile::findOne($userid)->marital_status;
                                            $martial = \backend\models\SMaritalStatus::findOne($mstatus);
                                            ?><?= (isset($martial->status)) ? $martial->status : ''; ?></td></tr>

                                    <tr>
                                        <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Birthday </div><?php $dob = \common\models\UserProfile::findOne($userid) ?><?= (isset($dob->dob)) ? $dob->dob : ''; ?></td>
                                        <td>  </td>

                                    </tr>
                                    <?php
                                    foreach ($address as $addresses) {
                                        ?>
                                        <tr><td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Province</div><?php
                                                $pro = backend\models\SDistrict::findOne($addresses['district_id'])->province_id;
                                                $prov = backend\models\SProvince::findOne($pro);
                                                ?><?= (isset($prov->province)) ? $prov->province : ''; ?></td></tr>
                                        <tr>
                                            <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">District</div> <?php $distr = backend\models\SDistrict::findOne($addresses['district_id']); ?><?= (isset($distr->district)) ? $distr->district : ''; ?></td></tr>
                                        <tr>
                                            <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Sector</div> <?php $sector = backend\models\SGeosector::findone($addresses['sector_id']); ?><?= (isset($sector->sector)) ? $sector->sector : ''; ?></td>


                                        </tr> 
                                    <?php } ?>
                                    <tr>
                                        <td><div class="pxp-single-candidate-side-info-label pxp-text-lighta">Country </div><?php
                                            $country = \common\models\UserProfile::findOne($userid)->nationality;
                                            $pays = backend\models\SCountrycodeIso3166::findOne($country);
                                            ?><?= (isset($pays->cc_description)) ? $pays->cc_description : ''; ?>  </td>

                                    </tr>
                                </table>
                            </div>

                            <div class="pxp-single-candidate-side-panel mt-4">
                                <h3>Contact <?php $fname = common\models\UserProfile::findOne($userid); ?>
                                    <?= (isset($fname->firstname)) ? $fname->firstname : ''; ?></h3>
                                <form class="mt-4">
                                    <div class="mb-3">
                                        <label for="contact-candidate-name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="contact-candidate-name" placeholder="Enter your name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="contact-candidate-email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="contact-candidate-email" placeholder="Enter your email address">
                                    </div>
                                    <div class="mb-3">
                                        <label for="contact-candidate-message" class="form-label">Message</label>
                                        <textarea class="form-control" id="contact-candidate-message" placeholder="Type your message here..."></textarea>
                                    </div>
                                    <a href="#" class="btn rounded-pill pxp-section-cta d-block">Send Message</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
