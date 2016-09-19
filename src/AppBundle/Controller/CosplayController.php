<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CosplayController extends Controller {

    public function indexAction(Request $request)
    {
        $category = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Category')
            ->findByName('Cosplay')
        ;

        $lastCosplayArticles = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Article')
            ->getLastArticles(4, $category)
            ;

        return $this->render('AppBundle:Cosplay:index.html.twig', array(
            'lastCosplayArticles' => $lastCosplayArticles
        ));
    }

}
