<?php
namespace frontend\notifier;

use Yii;
use frontend\notifier\NotificationInterface;

class Notifier
{
    private $notification;

    public function __construct(NotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    public function sendEmails($mediatorEmail)
    {
        if (!$this->notification->isAllowSendToEmail()) {
            return false;
        }
        
        $to = $this->notification->getToUser();
        
        if (!$to || empty($to->email)) {
            // can't send emails
            return false;
        }

        return Yii::$app->mailer->compose()
            ->setFrom($mediatorEmail)
            ->setTo($to->email)
            ->setSubject($this->notification->getSubject())
            ->setTextBody($this->notification->getText())
            ->send();
    }
}