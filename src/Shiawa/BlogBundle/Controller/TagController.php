<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Article;
use Shiawa\BlogBundle\Entity\AnimeReview;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TagController extends Controller
{
    public function viewAction($page, $tag)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $categoryName = $category;

        $category = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Category')
            ->findOneByName($categoryName)
        ;

        $em = $this->getDoctrine()->getManager();
        $artRep = $em->getRepository('ShiawaBlogBundle:Article');

        $nbPerPage = 9;

        $listArticles = $artRep->getArticles($page, $nbPerPage, $category);
        $nbPage = ceil(count($listArticles)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listArticles) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:Article:index.html.twig', array(
            'listArticles' => $listArticles,
            'page' => $page,
            'nbPages' => $nbPage,
            'category' => $category
        ));
    }
}
