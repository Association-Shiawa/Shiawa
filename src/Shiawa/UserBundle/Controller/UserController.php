<?php

namespace Shiawa\UserBundle\Controller;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Shiawa\UserBundle\Entity\User;
use Shiawa\UserBundle\Form\AvatarType;
use Shiawa\UserBundle\Form\UserAdminAddType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShiawaUserBundle:User:index.html.twig');
    }

    public function viewAction($username)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);

        return $this->render('ShiawaUserBundle:User:view.html.twig', array(
            'user' => $user
        ));
    }

    public function avatarUploadAction(Request $request){
        $user = $this->getUser();
        $form = $this->createForm(AvatarType::class, $user);

        $file = $request->files->get('avatar_avatar');
        $submitted['avatar']['file'] = $file;

        $form->submit($submitted);

        if ($request->isMethod('POST') && $form->isValid()) {

            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            return $this->json(array(true), 200);
        }else{
            return $this->json(array(false), 500);
        }
    }
}
