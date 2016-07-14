<?php

namespace Shiawa\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShiawaUserBundle:Default:index.html.twig');
    }
}
