<?php

namespace Ligneus\TrackerBundle\Service;

use Ligneus\DataBundle\Entity\Incident;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class TrackerService
{
    /**
     * @var SlackService
     */
    private $slack;
    private $validator;
    private $doctrine;
    private $routing;
    private $mail;
    private $templating;
    private $appService;

    public function __construct($slack, $validator, $doctrine, $routing, $mail, $templating, $appService)
    {
        $this->slack = $slack;
        $this->validator = $validator;
        $this->doctrine = $doctrine;
        $this->routing = $routing;
        $this->mail = $mail;
        $this->templating = $templating;
        $this->appService = $appService;
    }

    public function trackError($app, $errorData, $type = 'EXCEPTION', $options = [])
    {
        $incident = new Incident();
        $incident
            ->setOccurrence(new \DateTime('now'))
            ->setStatusCode($errorData->status)
            ->setText($errorData->text)
            ->setTitle($errorData->title)
            ->setApplication($app)
            ->setTrace($errorData->trace)
            ->setMessage($errorData->message)
            ->setClass($errorData->class)
            ->setUri($errorData->uri)
            ->setIp($errorData->ip)
        ;

        //resolve options
        if (count($options) > 0) {
            (isset($options['heartbeat'])) ? $heartbeat = $options['heartbeat'] : $heartbeat = null;
        }

        if (!(!$heartbeat)) {
            $incident->setHeartbeat($heartbeat);
        }

        $errors = $this->validator->validate($incident);

        if (count($errors) > 0) {
            throw new \Exception($errors);
        }

        $em = $this->doctrine->getManager();
        $em->persist($incident);
        $em->flush();

        //send email
        if ($app->getSendEmail() && strlen($app->getEmailRecipients()) > 0 && !$this->appService->getIncidentIsSilent($incident)) {
            $recipients = explode(';', $app->getEmailRecipients());

            $this->mail->sendMailErrorMessage(
                sprintf('[%s][%s] %s', $type, strtoupper($app->getName()), $incident->getMessage()),
                $this->templating->render('Email/incident.html.twig', array('application' => $app, 'incident' => $incident)),
                $recipients
            );
        }

        //send slack notif
        if ($app->getSendSlack() && strlen($app->getSlackUrl()) > 0 && !$this->appService->getIncidentIsSilent($incident)) {
            $heartbeat = $this->doctrine->getRepository('LigneusDataBundle:Heartbeat')->getOneByIpAndApp($errorData->ip, $app);

            if (!$heartbeat) {
                $reqClient = $errorData->ip;
            } else {
                $reqClient = ($heartbeat->getAlias() != '') ? $errorData->ip.' ('.$heartbeat->getAlias().')' : $errorData->ip;
            }

            $message = sprintf(
                '[%s][%s] %s\n*URI:* %s\n*Incident:* %s\n*Client:* %s',
                $type,
                strtoupper($app->getName()),
                $incident->getMessage(),
                $incident->getUri(),
                $this->routing->generate('incidents_detail', [
                    'incidentId' => $incident->getId(),
                ], true),
                $reqClient
            );

            $this->slack->sendSlackMessage($app->getSlackUrl(), $message, 'AppMonitor');
        }
    }
}
