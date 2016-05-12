<?php

namespace Ligneus\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ligneus\DataBundle\Entity\SilentMessage;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class IncidentController extends Controller
{
    public function likeAction($incidentId)
    {
        $incident = $this->getDoctrine()
            ->getRepository('LigneusDataBundle:Incident')
            ->findOneById($incidentId)
        ;

        $incidents = $this->getDoctrine()
            ->getRepository('LigneusDataBundle:Incident')
            ->findLikeMessage($incident->getMessage(), 50)
        ;

        return $this->render('Incident/like.html.twig', [
            'incidents' => $incidents,
            'incident' => $incident,
        ]);
    }

    public function detailAction($incidentId)
    {
        $incident = $this->getDoctrine()
            ->getRepository('LigneusDataBundle:Incident')
            ->findOneById($incidentId)
        ;

        $firstSeen = $this->getDoctrine()
            ->getRepository('LigneusDataBundle:Incident')
            ->getFirstOccurrance($incident->getMessage())
        ;

        $lastSeen = $this->getDoctrine()
            ->getRepository('LigneusDataBundle:Incident')
            ->getLastOccurrance($incident->getMessage())
        ;

        $incidentsAlike = $this->getDoctrine()
            ->getRepository('LigneusDataBundle:Incident')
            ->findLikeMessage($incident->getMessage(), 5)
        ;

        return $this->render('Incident/detail.html.twig', [
            'incident' => $incident,
            'incidents' => $incidentsAlike,
            'firstSeen' => $firstSeen,
            'lastSeen' => $lastSeen,
        ]);
    }

    public function silenceAction($incidentId)
    {
        $incident = $this->getDoctrine()
            ->getRepository('LigneusDataBundle:Incident')
            ->findOneById($incidentId)
        ;

        $em = $this->getDoctrine()->getManager();
        $silent = $this->getDoctrine()->getRepository('LigneusDataBundle:Incident')->isSilent($incident);

        if ($silent) {
            $sm = $this->getDoctrine()
                ->getRepository('LigneusDataBundle:SilentMessage')
                ->findOneByMessage($incident->getMessage())
            ;

            $em->remove($sm);
        } else {
            $sm = new SilentMessage();
            $sm->setMessage($incident->getMessage());

            $em->persist($sm);
        }

        $em->flush();

        return $this->redirectToRoute('incidents_detail', ['incidentId' => $incident->getId()]);
    }
}
