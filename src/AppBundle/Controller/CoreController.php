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
            ->findByRoles(['ROLE_ADHERENT', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);
        shuffle($adherents);

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
            'lastReview' => $lastReview,
            'nextEvent' => $nextEvent
        ));
    }

    public function contactAction() {


        return $this->render('AppBundle:Core:contact.html.twig', array(

        ));
    }
}
