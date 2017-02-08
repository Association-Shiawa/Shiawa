<?php

namespace Shiawa\BlogBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Shiawa\BlogBundle\Entity\AnimeReview;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{
    public function getArticles($page, $nbPerPage, $search)
    {
        $query = $this->createQueryBuilder('a');

        if(isset($search["category"])) {
            $query->orWhere('a.category IN (:categories)')
                ->setParameter('categories', $search["category"]);
        }
        if(isset($search["tags"])) {
            $query->leftJoin('a.tags', 't')
                ->orWhere("t.name IN (:tags)")
                ->setParameter('tags', $search["tags"]);
        }
        if(isset($search["title"])) {
            $query->orWhere('a.title LIKE :title')
                ->setParameter('title', '%'.$search["title"].'%');
        }

        $query->orderBy('a.createdAt', 'DESC')
        ->getQuery();

        $query
            ->setFirstResult(($page-1)* $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }

    public function  getLastArticles($nb, $category = null) {
        $query = $this->createQueryBuilder('a');

        if($category != null) {
            $query->where('a.category = :category')
                ->setParameter('category', $category);
        }

        $query
            ->andWhere('a.published = true')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults($nb);

        return $query->getQuery()->getResult();
    }

    public function  getLastTutorials($nb, $category = null) {
        $query = $this->createQueryBuilder('a');

        if($category != null) {
            $query->where('a.category = :category')
                ->setParameter('category', $category);
        }

        $query->andWhere('a.chapter IS NOT NULL')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults($nb);

        return $query->getQuery()->getResult();
    }

    public function findByTags($tags, $limit, $id = null) {

        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.tags', 't')
        ;

        /*for($i=0; $i < count($tags); $i++) {
            $query->orWhere('t.id = :tag'.$i);
        }

        for($i=0; $i < count($tags); $i++) {
            $query->setParameter('tag'.$i, $tags[$i]);
        }*/

        $query->where("t.id IN (:tags)")
            ->setParameter('tags', $tags);

        if($id != null){
            $query->andWhere('a.id != :id')
                ->setParameter('id', $id);
        }

        $query->distinct()
            ->setMaxResults($limit);

        return $query->getQuery()->getResult();
    }
}
