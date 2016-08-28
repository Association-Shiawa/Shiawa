<?php

namespace Shiawa\ContestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContestController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShiawaContestBundle:Contest:index.html.twig');
    }

    public function viewAction()
    {
        return $this->render('ShiawaContestBundle:Contest:view.html.twig');
    }
}
