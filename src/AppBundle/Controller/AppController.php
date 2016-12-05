<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class AppController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('App/dashboard.html.twig');
    }
}
