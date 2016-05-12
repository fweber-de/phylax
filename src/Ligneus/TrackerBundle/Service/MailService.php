<?php

namespace Ligneus\TrackerBundle\Service;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class MailService
{
    private $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMailErrorMessage($subject, $body, $recipients)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('exc@ligneus.de')
            ->setTo($recipients)
            ->setBody($body, 'text/plain')
        ;

        $this->mailer->send($message);
    }
}
