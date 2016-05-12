<?php

namespace Ligneus\DataBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class HeartbeatRepository extends EntityRepository
{
    public function getOneByIpAndApp($ip, Application $app)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
                    ->select('h')
                    ->from('LigneusDataBundle:Heartbeat', 'h')
                    ->join('h.application', 'a')
                    ->addSelect('a')
                    ->where('a.id = :applicationId')
                    ->andWhere('h.ip = :ip')
                    ->setParameter('applicationId', $app->getId())
                    ->setParameter('ip', $ip)
                    ->getQuery();

        $result = $query->getResult();

        return (count($result) == 0) ? $result : $result[0];
    }
}
