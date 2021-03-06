<?php

namespace Shiawa\EventBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends \Doctrine\ORM\EntityRepository
{
    public function getEvents($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('e')
            ->orderBy('e.beginAt', 'DESC')
            ->getQuery();

        $query
            ->setFirstResult(($page-1)* $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }

    public function getNext($limit)
    {
        $query = $this->createQueryBuilder('e')
            ->where('e.endAt >= :now')
            ->setParameter('now', new \DateTime('now'))
            ->orderBy('e.beginAt', 'ASC')
            ->getQuery()
            ->setMaxResults($limit);

        return $query->getResult();
    }

    public function getLast($limit)
    {
        $query = $this->createQueryBuilder('e')
            ->orderBy('e.beginAt', 'DESC')
            ->getQuery()
            ->setMaxResults($limit);

        return $query->getResult();
    }
}
