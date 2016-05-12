<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class ApplicationController extends AbstractApiController
{
    public function collectionAction()
    {
        $applications = $this->getDoctrine()->getRepository('DataBundle:Application')->findAll();

        return $this->getApiResponse($applications);
    }

    public function entityAction($applicationId)
    {
        $application = $this->getDoctrine()->getRepository('DataBundle:Application')->findOneById($applicationId);

        return $this->getApiResponse($application);
    }

    public function entityIncidentsAction(Request $request, $applicationId)
    {
        $application = $this->getDoctrine()->getRepository('DataBundle:Application')->findOneById($applicationId);
        $incidents = $this->getDoctrine()->getRepository('DataBundle:Incident')->getPaginatedByApplicationId(
            $this->get('knp_paginator'), $applicationId, $request->query->get('page', 1), $request->query->get('limit', 10)
        );

        return $this->getApiResponse($incidents->getItems());
    }
}
