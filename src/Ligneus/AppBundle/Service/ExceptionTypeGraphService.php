<?php

namespace Ligneus\AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Ligneus\DataBundle\Entity\Application;

class ExceptionTypeGraphService
{
    /**
     * @var Registry
     */
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getData(Application $application = null)
    {
        if (!$application) {
            $sql = sprintf(
                    'select class as label, count(*) as value from incident group by class'
            );
        } else {
            $sql = sprintf(
                    'select class as label, count(*) as value from incident where application_id = %s group by class', $application->getId()
            );
        }

        $stmt = $this->doctrine->getManager()->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }
}
