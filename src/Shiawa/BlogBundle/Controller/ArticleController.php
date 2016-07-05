<?php

namespace Shiawa\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getEntityManager();
        $artRep = $em->getRepository('ShiawaBlogBundle:Article');

        $nbPerPage = 3;

        $listArticles = $artRep->getArticles($page, $nbPerPage);
        $nbPage = ceil(count($listArticles)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listArticles) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:Article:index.html.twig', array(
            'listArticles' => $listArticles,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction()
    {
        return $this->render('ShiawaBlogBundle:Article:view.html.twig');
    }

    public function addAction()
    {
        return $this->render('ShiawaBlogBundle:Article:view.html.twig');
    }

    public function editAction()
    {
        return $this->render('ShiawaBlogBundle:Article:add.html.twig');
    }

    public function deleteAction()
    {
        return $this->render('ShiawaBlogBundle:Article:edit.html.twig');
    }
}
