<?php

namespace Scrumban\Repository;

use Doctrine\ORM\EntityRepository;

class SprintRepository extends EntityRepository
{
    public function getCurrentSprint()
    {
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
            ->where('s.beginAt <= ?', $now->format('Y-m-d H:i:s'))
            ->andWhere('s.endedAt >= ?', $now->format('Y-m-d H:i:s'))
            ->getQuery()
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