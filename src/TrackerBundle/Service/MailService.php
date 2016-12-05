<?php

namespace TrackerBundle\Service;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class MailService
{
    private $mailer;
    private $fromAddress;

    public function __construct($mailer, $fromAddress)
    {
        $this->mailer = $mailer;
        $this->fromAddress = $fromAddress;
    }

    public function sendMailErrorMessage($subject, $body, $recipients)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->fromAddress)
            ->setTo($recipients)
            ->setBody($body, 'text/plain')
        ;

        $this->mailer->send($message);
    }
}
