<?php


namespace frontend\notifier;

use frontend\notifier\NotificationInterface;
use common\models\ServiceJob;
use common\models\User;
use yii\helpers\Url;

class NewOpportunityNotification implements NotificationInterface
{
    private $opportunity;

    /**
     * NewProjectNotification constructor.
     * @param ServiceJob $opportunity
     */
    public function __construct(ServiceJob $opportunity)
    {
        $this->opportunity = $opportunity;
    }

    /**
     * @return User
     */
    public function getToUser()
    {
        return User::findByUsername('webmaster');
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return 'New opportunity at JobPortal!';
    }

    /**
     * @return string
     */
    public function getText()
    {
        $link = Url::to(['service-job/index'], true);

        return <<<TEXT
There's a new opportunity at JobPortal:

$link
TEXT;

    }

    /**
     * @inheritdoc
     */
    public function isAllowSendToEmail()
    {
        return true;
    }
}
