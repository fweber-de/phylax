<?php

namespace AppBundle\Service;

use AppBundle\Entity\Notification;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
interface NotificationServiceInterface
{
    public function notify(Notification $notification);
}
