<div class="modal fade pxp-user-modal" id="settings" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $request = \Yii::$app->request;
                echo $this->render('_formSettings', [
                    'model' => $jobseeker->userProfile,
                    'account' => $account
                ]);
                ?>
            </div>
        </div>
    </div>
</div>