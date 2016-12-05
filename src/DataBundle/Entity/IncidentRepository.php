<?php

namespace DataBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class IncidentRepository extends EntityRepository
{
    public function getPaginatedByApplicationId($paginator, $applicationId, $page, $limit)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('i')
            ->from('DataBundle:Incident', 'i')
            ->join('i.application', 'a')
            ->addSelect('a')
            ->where('a.id = :applicationId')
            ->orderBy('i.occurrence', 'desc')
            ->setParameter('applicationId', $applicationId)
        ;

        $incidents = $paginator->paginate(
            $query, $page, $limit
        );

        return $incidents;
    }

    public function getPaginated($paginator, $page, $limit)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('i')
            ->from('DataBundle:Incident', 'i')
            ->orderBy('i.occurrence', 'desc')
        ;

        $incidents = $paginator->paginate(
            $query, $page, $limit
        );

        return $incidents;
    }

    public function findLikeMessage($message, $limit = 50)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('i')
            ->from('DataBundle:Incident', 'i')
            ->where('i.message = :message')
            ->orderBy('i.occurrence', 'desc')
            ->setParameter('message', $message)
            ->setMaxResults($limit)
            ->getQuery()
        ;

        return $query->getResult();
    }

    public function getFirstOccurrance($message)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('i')
            ->from('DataBundle:Incident', 'i')
            ->where('i.message = :message')
            ->orderBy('i.occurrence', 'asc')
            ->setParameter('message', $message)
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $query->getResult()[0];
    }

    public function getLastOccurrance($message)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('i')
            ->from('DataBundle:Incident', 'i')
            ->where('i.message = :message')
            ->orderBy('i.occurrence', 'desc')
            ->setParameter('message', $message)
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $query->getResult()[0];
    }

    public function isSilent($incident)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('s')
            ->from('DataBundle:SilentMessage', 's')
            ->where('s.message = :message')
            ->setParameter('message', $incident->getMessage())
            ->setMaxResults(1)
            ->getQuery()
        ;

        if (count($query->getResult()) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
