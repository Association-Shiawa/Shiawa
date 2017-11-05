<?php

namespace AppBundle\CustomCKFinderAuth;

use CKSource\Bundle\CKFinderBundle\Authentication\Authentication as AuthenticationBase;

class CustomCKFinderAuth extends AuthenticationBase
{
    public function authenticate()
    {
       if($this->container->get('security.authorization_checker')->isGranted('ROLE_AUTHOR'))
       {
           return true;
       }

       return false;
    }
}