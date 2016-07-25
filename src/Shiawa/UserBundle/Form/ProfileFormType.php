<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shiawa\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('avatar', TextType::class, array(
            'required'     => false
            ))
            ->add('name', TextType::class, array(
                'required'     => false
            ))
            ->add('surname', TextType::class, array(
                'required'     => false
            ))
            ->add('birthdate', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'required' => false
            ))
            ->add('description', TextareaType::class, array(
                'required'     => false
            ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getName()
    {
        return 'shiawa_user_profile_edit';
    }
}
