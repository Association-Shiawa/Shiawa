<?php

namespace Shiawa\BlogBundle\Form;

use Shiawa\FileBundle\Form\FileUploadType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('thumbnail', FileUploadType::class, array(
                'required' => false
            ))
            ->add('synopsis')
            ->add('nbrEpisode')
            ->add('type', ChoiceType::class, array(
            'choices'  => array(
                'Shonen' => 'Shonen',
                'Shojo' => 'Shojo',
                'Shojo Ai - Yuri' => 'Shojo-ai',
                'Shonen-ai - Yaoi' => 'Shonen-ai',
                'Seinen' => 'Seinen',
                'Josei - Shojo Mature' => 'Josei'
            )))
            ->add('editor', EntityType::class, array(
                'class'        => 'ShiawaBlogBundle:Editor',
                'choice_label' => 'name',
                'multiple'     => false,
                'required'     => false
            ))
            ->add('studio', EntityType::class, array(
                'class'        => 'ShiawaBlogBundle:Studio',
                'choice_label' => 'name',
                'multiple'     => false,
                'required'     => false
            ))
            ->add('isNew', CheckboxType::class, array('required' => false))
            ->add('save',      SubmitType::class);
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shiawa\BlogBundle\Entity\Anime'
        ));
    }
}
