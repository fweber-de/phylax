<?php

namespace AppBundle\Twig;

use DataBundle\Entity\Application;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class AppExtension extends \Twig_Extension
{
    private $applicationService;

    public function __construct($applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('app_get_total_ping_state', array($this, 'getTotalPingState')),
            new \Twig_SimpleFunction('app_get_incident_count_24h', array($this, 'getIncidentCount24h')),
            new \Twig_SimpleFunction('app_get_incident_count_14d', array($this, 'getIncidentCount14d')),
            new \Twig_SimpleFunction('app_get_number_incident_events', array($this, 'getNumberOfIncidentEvents')),
            new \Twig_SimpleFunction('app_get_incident_is_silent', array($this, 'getIncidentIsSilent')),
        );
    }

    public function getTotalPingState(Application $application)
    {
        return $this->applicationService->getTotalPingState($application);
    }

    public function getIncidentCount24h($obj)
    {
        return $this->applicationService->getIncidentCount24h($obj);
    }

    public function getIncidentCount14d($obj)
    {
        return $this->applicationService->getIncidentCount14d($obj);
    }

    public function getNumberOfIncidentEvents($event)
    {
        return $this->applicationService->getNumberOfIncidentEvents($event);
    }

    public function getIncidentIsSilent($incident)
    {
        return $this->applicationService->getIncidentIsSilent($incident);
    }

    public function getName()
    {
        return 'app_extension';
    }
}
