<?php

namespace Shiawa\BlogBundle\Utils;

use Doctrine\ORM\EntityManager;

class TagsManagement
{
    private $em;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    public function setArticleTags($article)
    {
        $tagRep = $this->em->getRepository('ShiawaBlogBundle:Tag');

        $tags = $article->getTags();
        $nbTags = count($tags);
        for($i=0; $i < count($tags); $i++) {
            $tag = $tags[$i];

            if($tag === null) {
                $nbTags++;
            }else{
                $tag->setName(strtolower($tag->getName()));
                $tagDb = $tagRep->findOneByName($tag->getName());

                if(!$tagDb == null){
                    $tags[$i] = $tagDb;
                }
            }
        }

        return $article;
    }
}