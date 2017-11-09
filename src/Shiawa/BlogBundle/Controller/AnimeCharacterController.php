<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\AnimeCharacter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AnimeCharacterController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $charaRep = $em->getRepository('ShiawaBlogBundle:AnimeCharacter');

        $nbPerPage = 5;

        $listChars = $charaRep->getCharacters($page, $nbPerPage);
        $nbPage = ceil(count($listChars)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listChars) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:AnimeCharacter:index.html.twig', array(
            'listChars' => $listChars,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($slug)
    {
        $char = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:AnimeCharacter')
            ->findOneBySlug($slug);


        return $this->render('ShiawaBlogBundle:AnimeCharacter:view.html.twig', array(
            'char' => $char
        ));
    }

    public function newsAction()
    {
        $lastAnimes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Anime')
            ->getNew()
        ;

        return $this->render('ShiawaBlogBundle:Anime:new_anime.html.twig', array(
            'lastAnimes' => $lastAnimes
        ));
    }
}
