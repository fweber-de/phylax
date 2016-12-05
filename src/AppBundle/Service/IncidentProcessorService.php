<?php

namespace AppBundle\Service;

use AppBundle\Entity\Incident;
use AppBundle\Entity\Notification;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class IncidentProcessorService
{
    private $doctrine;
    private $notificationServices = [];

    public function __construct($doctrine, $notificationServices)
    {
        $this->doctrine = $doctrine;
        $this->notificationServices = $notificationServices;
    }

    public function process(Incident $incident)
    {
        $em = $this->doctrine->getManager();

        //are there any global incident filters?

        //notify teams which subscribe to the source
        $teams = $this->doctrine->getRepository('AppBundle:Team')->findTeamsBySource($incident->getSource());

        foreach ($teams as $team) {
            //are there any team specific incident filters?

            //notification
            $notification = new Notification();
            $notification
                ->setIncident($incident)
                ->setTeam($team)
            ;

            //notify configured services
            foreach ($team->getServices() as $service) {
                //is there another notification für this incident, team and service?
                $query = $em->createQueryBuilder()
                    ->select('n')
                    ->from('AppBundle:Notification', 'n')
                    ->join('n.incident', 'i')
                    ->join('n.team', 't')
                    ->join('n.service', 'svc')
                    ->addSelect('i')
                    ->addSelect('t')
                    ->addSelect('svc')
                    ->where('i.id = :incident')
                    ->where('t.id = :team')
                    ->where('svc.id = :service')
                    ->setParameter('incident', $incident->getId())
                    ->setParameter('team', $team->getId())
                    ->setParameter('service', $service->getId())
                    ->getQuery()
                ;
                $result = $query->getResult();

                if(count($result) > 0) {
                    continue;
                }

                //send & save
                $svc = $this->notificationServices[$service->getDefinedName()];

                $svc->notify($notification);

                $em->persist($notification);                
            }
        }

        $em->flush();
    }
}
