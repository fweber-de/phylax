<?php

namespace Ligneus\AppBundle\Twig;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class StringExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('format_trace', array($this, 'formatTraceFilter')),
            new \Twig_SimpleFilter('gravatarHash', array($this, 'gravatarHashFilter')),
        );
    }

    public function formatTraceFilter($trace)
    {
        return str_replace('#', '<br>#', $trace);
    }

    public function gravatarHashFilter($email)
    {
        return md5(strtolower(trim($email)));
    }

    public function getName()
    {
        return 'string_extension';
    }
}
