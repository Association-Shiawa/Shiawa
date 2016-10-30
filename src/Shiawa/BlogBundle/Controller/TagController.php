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
    public function viewAction($tag)
    {

        $em = $this->getDoctrine()->getManager();
        $tagRep = $em->getRepository('ShiawaBlogBundle:Tag');

        $listArticles = $tagRep->findArticles($tag);
        $listAnimeReview = $tagRep->findAnimeReview($tag);

        return $this->render('ShiawaBlogBundle:Tag:view.html.twig', array(
            'listArticles' => $listArticles,
            'listAnimeReview' => $listAnimeReview,
            'tag' => $tag
        ));
    }
}
