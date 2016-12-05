<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class AppController extends Controller
{
    public function dashboardAction()
    {
        $sources = $this->getDoctrine()->getRepository('AppBundle:Source')->findAll();

        return $this->render('App/dashboard.html.twig', [
            'sources' => $sources,
        ]);
    }
}
