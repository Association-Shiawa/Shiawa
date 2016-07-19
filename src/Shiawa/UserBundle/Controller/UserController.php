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

    public function AdminRegisterAction(Request $request) {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(true)
            ;

        $form = $this->createForm(UserAdminAddType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $userManager->updateUser($user);

            $request->getSession()->getFlashBag()->add('notice', 'Utilisateur '. $user->getUsername() .'bien
            enregistrée');

            return $this->redirectToRoute('shiawa_admin_homepage', array(
            ));
        }

        return $this->render('ShiawaUserBundle:Admin:add.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
