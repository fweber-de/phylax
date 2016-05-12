<?php

namespace Ligneus\AppBundle\Service;

use Ligneus\DataBundle\Entity\Application;
use Ligneus\DataBundle\Entity\Incident;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class ApplicationService
{
    private $pingThreshold;
    private $doctrine;

    public function __construct($pingThreshold, $doctrine)
    {
        $this->pingThreshold = $pingThreshold;
        $this->doctrine = $doctrine;
    }

    /**
     * Calculates the seconds between two dates.
     *
     * @param \DateTime $dateA
     * @param \DateTime $dateB
     *
     * @return int
     */
    public function getTimeDiff($dateA, $dateB)
    {
        $timeFirst = strtotime($dateA->format('Y-m-d H:i:s'));
        $timeSecond = strtotime($dateB->format('Y-m-d H:i:s'));

        return $timeSecond - $timeFirst;
    }

    /**
     * Gets the state of all monitored heartbeats.
     *
     * @param Application $application
     *
     * @return bool
     */
    public function getTotalPingState(Application $application)
    {
        $heartbeats = $application->getHeartbeats();
        $total = count($heartbeats);
        $totalMonitored = 0;
        $totalOnline = 0;

        foreach ($heartbeats as $hb) {
            if ($hb->getMonitor()) {
                ++$totalMonitored;
            }

            if ($this->getTimeDiff($hb->getLastPing(), new \DateTime('now')) <= $this->pingThreshold && $hb->getMonitor()) {
                ++$totalOnline;
            }
        }

        return ($totalMonitored == $totalOnline);
    }

    public function getIncidentCount24h($obj)
    {
        $start = (new \DateTime())->modify('-23 hours');

        //set minutes, seconds to 0
        $start = $start->setTime($start->format('H'), 0, 0);

        $d = clone $start;
        $data = [];

        if ($obj instanceof Application) {
            foreach (range(1, 24) as $i) {
                $sql = sprintf('
                    SELECT  HOUR(occurrence) as HOUR
                        ,   COUNT(*) as COUNT
                    FROM    incident
                    WHERE   application_id = %s
                        AND occurrence >= \'%s\'
                        AND occurrence <= \'%s\'
                    GROUP BY HOUR(occurrence)
                ', $obj->getId(), $d->format('Y-m-d H:i:s'), $d->modify('+1 hours')->format('Y-m-d H:i:s'));

                $stmt = $this->doctrine->getManager()->getConnection()->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (count($result) > 0) {
                    $data[] = intval($result[0]['COUNT']);
                } else {
                    $data[] = 0;
                }
            }
        } elseif ($obj instanceof Incident) {
            foreach (range(1, 24) as $i) {
                $sql = sprintf('
                    SELECT  HOUR(occurrence) as HOUR
                        ,   COUNT(*) as COUNT
                    FROM    incident
                    WHERE   message = \'%s\'
                        AND occurrence >= \'%s\'
                        AND occurrence <= \'%s\'
                    GROUP BY HOUR(occurrence)
                ', addslashes($obj->getMessage()), $d->format('Y-m-d H:i:s'), $d->modify('+1 hours')->format('Y-m-d H:i:s'));

                $stmt = $this->doctrine->getManager()->getConnection()->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (count($result) > 0) {
                    $data[] = intval($result[0]['COUNT']);
                } else {
                    $data[] = 0;
                }
            }
        }

        return $data;
    }

    public function getIncidentCount14d($obj)
    {
        $start = (new \DateTime())->modify('-13 days');

        //set minutes, seconds to 0
        $start = $start->setTime($start->format('H'), 0, 0);

        $d = clone $start;
        $data = [];

        if ($obj instanceof Application) {
            foreach (range(1, 14) as $i) {
                $sql = sprintf('
                    SELECT  DAY(occurrence) as DAY
                        ,   COUNT(*) as COUNT
                    FROM    incident
                    WHERE   application_id = %s
                        AND occurrence >= \'%s\'
                        AND occurrence <= \'%s\'
                    GROUP BY HOUR(occurrence)
                ', $obj->getId(), $d->format('Y-m-d H:i:s'), $d->modify('+1 days')->format('Y-m-d H:i:s'));

                $stmt = $this->doctrine->getManager()->getConnection()->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (count($result) > 0) {
                    $data[] = intval($result[0]['COUNT']);
                } else {
                    $data[] = 0;
                }
            }
        } elseif ($obj instanceof Incident) {
            foreach (range(1, 14) as $i) {
                $sql = sprintf('
                    SELECT  DAY(occurrence) as DAY
                        ,   COUNT(*) as COUNT
                    FROM    incident
                    WHERE   message = \'%s\'
                        AND occurrence >= \'%s\'
                        AND occurrence <= \'%s\'
                    GROUP BY HOUR(occurrence)
                ', addslashes($obj->getMessage()), $d->format('Y-m-d H:i:s'), $d->modify('+1 days')->format('Y-m-d H:i:s'));

                $stmt = $this->doctrine->getManager()->getConnection()->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (count($result) > 0) {
                    $data[] = intval($result[0]['COUNT']);
                } else {
                    $data[] = 0;
                }
            }
        }

        return $data;
    }

    public function getNumberOfIncidentEvents($event)
    {
        $sql = sprintf('
            select  COUNT(*) as C
            from    incident
            where   message = \'%s\'
        ', addslashes($event));

        $stmt = $this->doctrine->getManager()->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return (count($result) > 0) ? $result[0]['C'] : 0;
    }

    public function getIncidentIsSilent($incident)
    {
        return $this->doctrine->getRepository('LigneusDataBundle:Incident')->isSilent($incident);
    }
}
