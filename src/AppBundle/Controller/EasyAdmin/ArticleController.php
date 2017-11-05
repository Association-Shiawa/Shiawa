<?php

namespace AppBundle\Controller\EasyAdmin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Shiawa\BlogBundle\Entity\Article;

class ArticleController extends BaseAdminController
{

    public function createNewArticleEntity()
    {
        $article = new Article();

        if($this->request->query->has('chapter')) {
            $chapter = $this->em->find('ShiawaBlogBundle:Chapter', $this->request->query->get('chapter'));
            $article->setChapter($chapter);
        }
        return $article;
    }
}