<?php

namespace Shiawa\UserBundle\Form;

use Shiawa\FileBundle\Form\FileUploadType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('avatar', FileUploadType::class, array(
            'required'     => true
        ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shiawa\UserBundle\Entity\User',
            'csrf_protection' => false
        ));
    }
}
