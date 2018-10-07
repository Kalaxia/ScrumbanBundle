<?php

namespace Scrumban\Repository;

use Doctrine\ORM\EntityRepository;

class SprintRepository extends EntityRepository
{
    public function getCurrentSprint()
    {
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
            ->where('s.beginAt <= :begin_at')
            ->andWhere('s.endedAt >= :ended_at')
            ->setParameters([
                'begin_at' => $now->format('Y-m-d H:i:s'),
                'ended_at' => $now->format('Y-m-d H:i:s')
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    public function getPreviousSprint()
    {
        return $this->createQueryBuilder('s')
            ->where('s.endedAt <= :now')
            ->orderBy('s.endedAt', 'DESC')
            ->setParameters(['now' => (new \DateTime())->format('Y-m-d H:i:s')])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
    
    public function getSprintByPeriod(\DateTime $beginAt, \DateTime $endedAt)
    {
        return $this->createQueryBuilder('s')
            ->where('s.endedAt >= :begin_at')
            ->andWhere('s.beginAt <= :ended_at')
            ->setParameters([
                'begin_at' => $beginAt->format('Y-m-d H:i:s'),
                'ended_at' => $endedAt->format('Y-m-d H:i:s')
            ])
            ->getQuery()
            ->getResult();
    }
}