<?php

namespace AppBundle\Twig;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class SourceExtension extends \Twig_Extension
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFunction('phylax_source_getSources', array($this, 'getSources')),
        ];
    }

    public function getSources()
    {
        $sources = $this->doctrine->getRepository('AppBundle:Source')->findAll();

        return $sources;
    }

    public function getName()
    {
        return 'source_extension';
    }
}
