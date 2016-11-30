<?php

namespace Shiawa\FileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShiawaFileBundle:Default:index.html.twig');
    }
}
