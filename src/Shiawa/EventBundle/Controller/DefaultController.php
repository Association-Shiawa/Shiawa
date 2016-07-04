<?php

namespace Shiawa\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShiawaEventBundle:Default:index.html.twig');
    }
}
