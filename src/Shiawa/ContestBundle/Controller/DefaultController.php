<?php

namespace Shiawa\ContestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShiawaContestBundle:Default:index.html.twig');
    }
}
