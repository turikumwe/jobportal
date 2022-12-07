<?php

namespace frontend\notifier;

use common\models\User;

interface NotificationInterface
{
    /**
     * @return User
     */
    public function getToUser();

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return string
     */
    public function getText();

    /**
     * @return bool
     */
    public function isAllowSendToEmail();
    
}
