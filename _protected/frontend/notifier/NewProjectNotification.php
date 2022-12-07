<?php


namespace frontend\notifier;


use common\models\ServiceJob;
use common\models\User;
use yii\helpers\Url;

class NewOpportunityNotification implements NotificationInterface
{
    private $opportunity;

    /**
     * NewProjectNotification constructor.
     * @param Project $opportunity
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
        return User::findByUsername('samdark');
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
        $link = Url::to(['service-job/view', 'id' => $this->opportunity->id, 'slug' => $this->opportunity->slug], true);

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
