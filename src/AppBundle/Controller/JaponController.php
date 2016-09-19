<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JaponController extends Controller {

    public function indexAction(Request $request)
    {
        $category = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Category')
            ->findByName('Japon')
        ;

        $lastJapanArticles = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Article')
            ->getLastArticles(4, $category)
            ;

        return $this->render('AppBundle:Japon:index.html.twig', array(
            'lastJapanArticles' => $lastJapanArticles
        ));
    }

}
