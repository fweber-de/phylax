<?php

namespace Ligneus\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckHeartbeatCommand extends ContainerAwareCommand
{
    protected $applicationService;
    protected $slack;
    protected $mail;
    protected $tracker;

    protected function configure()
    {
        $this
            ->setName('exc:check:heartbeat')
            ->setDescription('Checks if Heartbeats are offline')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $context = $this->getContainer()->get('router')->getContext();
        $context->setHost('exc.ligneus.local');
        $context->setScheme('http');

        $this->applicationService = $this->getContainer()->get('exc.application');
        $this->slack = $this->getContainer()->get('exc.slack');
        $this->mail = $this->getContainer()->get('exc.mail');
        $this->tracker = $this->getContainer()->get('exc.tracker');

        $applications = $this->getContainer()->get('doctrine')->getRepository('LigneusDataBundle:Application')->findAll();
        $pingThreshold = $this->getContainer()->getParameter('exc.ping_threshold');

        foreach ($applications as $app) {
            $failedHeartbeats = 0;

            foreach ($app->getHeartbeats() as $hb) {
                if ($hb->getMonitor() && $this->applicationService->getTimeDiff($hb->getLastPing(), new \DateTime('now')) >= $pingThreshold && $hb->getNotified() == false) {
                    $this->handleError($app, $hb, $output);
                    ++$failedHeartbeats;
                }
            }

            if ($failedHeartbeats > 0) {
                $output->writeln(sprintf('[%s]    %s failed heartbeats', $app->getName(), $failedHeartbeats));
            }
        }
    }

    protected function handleError($app, $failedHeartbeat, $output)
    {
        //set notified toggle
        $failedHeartbeat->setNotified(true);

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->flush();

        $reqClient = ($failedHeartbeat->getAlias() != '') ? $failedHeartbeat->getIp().' ('.$failedHeartbeat->getAlias().')' : $failedHeartbeat->getIp();

        //track incident
        $this->tracker->trackError(
            $app,
            (object) [
                'status' => 0,
                'text' => null,
                'title' => null,
                'trace' => null,
                'message' => sprintf('Heartbeat from %s offline', $reqClient),
                'class' => null,
                'uri' => null,
                'ip' => $failedHeartbeat->getIp(),
            ],
            'ERROR',
            [
                'heartbeat' => $failedHeartbeat,
            ]
        );
    }
}
