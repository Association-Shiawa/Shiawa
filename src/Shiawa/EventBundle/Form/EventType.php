<?php

namespace Shiawa\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('beginAt', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false
            ))
            ->add('endAt', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false
            ))
            ->add('image')
            ->add('isPublic')
            ->add('adress')
            ->add('place')
            ->add('website')
            ->add('description')
            ->add('save', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shiawa\EventBundle\Entity\Event'
        ));
    }
}
