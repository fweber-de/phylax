<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class SourceController extends Controller
{
    public function collectionAction()
    {
        $sources = $this->getDoctrine()->getRepository('AppBundle:Source')->findAll();

        return $this->render('Source/collection.html.twig', [
            'sources' => $sources,
        ]);
    }
}
