<?php

namespace Shiawa\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ShiawaUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
