<?php

namespace Shiawa\ContestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupeController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShiawaContestBundle:Groupe:index.html.twig');
    }
}
