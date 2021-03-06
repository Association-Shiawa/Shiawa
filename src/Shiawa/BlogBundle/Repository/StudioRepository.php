<?php

namespace Shiawa\BlogBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * StudioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StudioRepository extends \Doctrine\ORM\EntityRepository
{
    public function getStudios($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('s');

        $query->orderBy('s.name', 'ASC')
            ->getQuery();

        $query
            ->setFirstResult(($page-1)* $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }
}
