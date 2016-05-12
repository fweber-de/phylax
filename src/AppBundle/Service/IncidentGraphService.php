<?php

namespace AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use DataBundle\Entity\Application;

class IncidentGraphService
{
    /**
     * @var Registry
     */
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param \DateTime   $begin
     * @param \DateTime   $end
     * @param Application $application
     *
     * @return mixed
     */
    public function getIncidentData(\DateTime $begin, \DateTime $end, Application $application = null)
    {
        $begin->setTime(0, 0, 0);
        $end->setTime(0, 0, 0);

        $labels = $this->getLabels($begin, $end);

        if (!$application) {
            $applications = $this->doctrine->getRepository('DataBundle:Application')->findAll();
        } else {
            $applications = array($application);
        }

        $data = array();

        foreach ($applications as $app) {
            $sql = sprintf(
                    'select count(*) as COUNT, date(occurrence) as DATE from INCIDENT where APPLICATION_ID = %s and date(OCCURRENCE) >= \'%s\' and date(OCCURRENCE) <= \'%s\' group by date(OCCURRENCE)', $app->getId(), $begin->format('Y-m-d G:i:s'), $end->format('Y-m-d G:i:s')
            );

            $stmt = $this->doctrine->getManager()->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $_data = array();

            foreach ($labels as $label) {
                $_data[] = $this->getResultForLabel($result, $label);
            }

            $data[$app->getName()] = $_data;
        }

        return array($labels, $data);
    }

    private function getLabels(\DateTime $begin, \DateTime $end)
    {
        $days = $begin->diff($end)->days;

        for ($i = $days; $i >= 0; --$i) {
            $date = (new \DateTime('now'))->modify(sprintf('-%s days', $i));
            $labels[] = $date->format('Y-m-d');
        }

        return $labels;
    }

    private function getResultForLabel($result, $label)
    {
        foreach ($result as $r) {
            if ($r['DATE'] == $label) {
                return (int) $r['COUNT'];
            }
        }

        return 0;
    }
}
