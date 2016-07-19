<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoreController extends Controller
{
    public function indexAction(Request $request)
    {
        $lastArticles = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Article')
            ->getLastArticles(4);

        $adherents = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaUserBundle:User')
            ->findByRoles(['ROLE_ADHERENT', 'ROLE_ADMIN']);

        $events = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaEventBundle:Event')
            ->getNext(2);

        return $this->render('AppBundle:Core:index.html.twig', array(
            'lastArticles' => $lastArticles,
            'adherents' => $adherents,
            'events' => $events
        ));
    }

    public function animeIndexAction(Request $request)
    {
        $category = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Category')
            ->findByName('Anime')
        ;

        $lastAnimeArticles = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Article')
            ->getLastArticles(4, $category)
            ;

        $lastEpisodes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Episode')
            ->getLast(3)
        ;

        return $this->render('AppBundle:Anime:index.html.twig', array(
            'lastAnimeArticles' => $lastAnimeArticles,
            'lastEpisodes' =>$lastEpisodes
        ));
    }

    public function asideAction() {
        $lastReview = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:AnimeReview')
            ->getLast(1);

        $nextEvent = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaEventBundle:Event')
            ->getNext(1);

        return $this->render('AppBundle:Anime:aside.html.twig', array(
            'lastReview' => $lastReview[0],
            'nextEvent' => $nextEvent
        ));
    }
}
