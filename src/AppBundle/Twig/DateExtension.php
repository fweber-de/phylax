<?php

namespace AppBundle\Twig;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class DateExtension extends \Twig_Extension
{
    private $applicationService;

    public function __construct($applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('diff_time', array($this, 'diffTimeFilter')),
        );
    }

    public function diffTimeFilter($dateA, $dateB)
    {
        return $this->applicationService->getTimeDiff($dateA, $dateB);
    }

    public function getName()
    {
        return 'date_extension';
    }
}
