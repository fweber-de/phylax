<?php

namespace Ligneus\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class ApplicationController extends AbstractApiController
{
    public function collectionAction()
    {
        $applications = $this->getDoctrine()->getRepository('LigneusDataBundle:Application')->findAll();

        return $this->getApiResponse($applications);
    }

    public function entityAction($applicationId)
    {
        $application = $this->getDoctrine()->getRepository('LigneusDataBundle:Application')->findOneById($applicationId);

        return $this->getApiResponse($application);
    }

    public function entityIncidentsAction(Request $request, $applicationId)
    {
        $application = $this->getDoctrine()->getRepository('LigneusDataBundle:Application')->findOneById($applicationId);
        $incidents = $this->getDoctrine()->getRepository('LigneusDataBundle:Incident')->getPaginatedByApplicationId(
            $this->get('knp_paginator'), $applicationId, $request->query->get('page', 1), $request->query->get('limit', 10)
        );

        return $this->getApiResponse($incidents->getItems());
    }
}
