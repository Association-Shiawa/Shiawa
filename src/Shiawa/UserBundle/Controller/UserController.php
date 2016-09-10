<?php

namespace Shiawa\UserBundle\Controller;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Shiawa\UserBundle\Entity\User;
use Shiawa\UserBundle\Form\UserAdminAddType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShiawaUserBundle:User:index.html.twig');
    }
}
