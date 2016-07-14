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

        return $this->render('AppBundle:Core:index.html.twig', array());
    }

    public function animeIndexAction(Request $request)
    {

        return $this->render('AppBundle:Core:index.html.twig', array());
    }
}
