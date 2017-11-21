<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\AnimeReview;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AnimeReviewController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $reviewRep = $em->getRepository('ShiawaBlogBundle:AnimeReview');

        $nbPerPage = 9;

        $listReview = $reviewRep->getReview($page, $nbPerPage);
        $nbPage = ceil(count($listReview)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listReview) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:AnimeReview:index.html.twig', array(
            'listAnimeReview' => $listReview,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($slug)
    {
        $review = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:AnimeReview')
            ->findOneBySlug($slug);


        return $this->render('ShiawaBlogBundle:AnimeReview:view.html.twig', array(
            'review' => $review
        ));
    }
}