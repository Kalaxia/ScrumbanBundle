<?php

namespace Scrumban\Repository;

use Doctrine\ORM\EntityRepository;

class SprintRepository extends EntityRepository
{
    public function getCurrentSprint()
    {
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
            ->where('s.beginAt <= ?', $now)
            ->andWhere('s.endedAt >= ?', $now)
            ->getQuery()
            ->getOneOrNullResult();
    }
}