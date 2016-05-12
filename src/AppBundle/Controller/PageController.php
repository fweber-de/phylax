<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class PageController extends Controller
{
    public function indexAction()
    {
        return $this->redirectToRoute('dashboard');
    }

    public function dashboardAction()
    {
        $applications = $this->getDoctrine()->getRepository('DataBundle:Application')->findAll();
        $appColors = array();

        foreach ($applications as $app) {
            $appColors[$app->getName()] = $app->getColorHex();
        }

        $data7Days = json_encode($this->get('exc.incident_graph')->getIncidentData((new \DateTime('now'))->modify('-6 days'), new \DateTime('now')));

        return $this->render('Page/dashboard.html.twig', array(
            'applications' => $applications,
            'appColors' => json_encode($appColors),
            'data7Days' => $data7Days,
        ));
    }

    public function streamAction(Request $request)
    {
        $incidents = $this->getDoctrine()->getRepository('DataBundle:Incident')->getPaginated(
            $this->get('knp_paginator'), $request->query->get('page', 1), $request->query->get('limit', 10)
        );

        return $this->render('Page/stream.html.twig', [
            'incidents' => $incidents,
        ]);
    }
}
