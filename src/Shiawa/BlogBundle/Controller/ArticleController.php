<?php

namespace Shiawa\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShiawaBlogBundle:Article:index.html.twig');
    }
}
