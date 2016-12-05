<?php

namespace AppBundle\Service;

use AppBundle\Entity\Notification;
use AppBundle\Service\NotificationServiceInterface;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class SlackNotificationService implements NotificationServiceInterface
{
    public function notify(Notification $notification)
    {

    }
}
