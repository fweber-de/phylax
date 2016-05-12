<?php

namespace Ligneus\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class IncidentController extends AbstractApiController
{
    public function collectionAction(Request $request)
    {
        $incidents = $this->getDoctrine()->getRepository('LigneusDataBundle:Incident')->getPaginated(
            $this->get('knp_paginator'), $request->query->get('page', 1), $request->query->get('limit', 10)
        );

        return $this->getApiResponse($incidents->getItems());
    }

    public function entityAction($incidentId)
    {
        $incident = $this->getDoctrine()->getRepository('LigneusDataBundle:Incident')->findOneById($incidentId);

        return $this->getApiResponse($incident);
    }

    public function entityTotalCountAction()
    {
        $count = $this->getDoctrine()
            ->getRepository('LigneusDataBundle:Incident')
            ->createQueryBuilder('i')
            ->select('count(i)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $this->getApiResponse([
            'count' => $count,
        ]);
    }
}
