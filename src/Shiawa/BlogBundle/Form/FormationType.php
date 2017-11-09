<?php

namespace Shiawa\BlogBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
//            ->add('thumbnail', FileType::class, array(
//                'required' => false
//            ))
            ->add('createdAt', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false
            ))
//            ->add('description')
            ->add('category', EntityType::class, array(
                'class'        => 'ShiawaBlogBundle:Category',
                'choice_label' => 'name',
                'multiple'     => false,
            ))
//            ->add('tags', CollectionType::class, array(
//                'entry_type'   => TagType::class,
//                'allow_add'    => true,
//                'allow_delete' => true,
//                'required' => false
//            ))
            ->add('save', SubmitType::class, array(
                'label' => "Valider"
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shiawa\BlogBundle\Entity\Formation'
        ));
    }
}
