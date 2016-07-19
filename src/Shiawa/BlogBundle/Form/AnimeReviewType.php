<?php

namespace Shiawa\BlogBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimeReviewType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('createdAt', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false
            ))
            ->add('anime', EntityType::class, array(
                'class'        => 'ShiawaBlogBundle:Anime',
                'choice_label' => 'title',
                'multiple'     => false
            ))
            ->add('image')
            ->add('introduction')
            ->add('criticScenario')
            ->add('criticGraphisms')
            ->add('criticSoundtrack')
            ->add('criticConsistency')
            ->add('noteScenario')
            ->add('noteGraphism')
            ->add('noteSoundtrack')
            ->add('noteCharacters')
            ->add('noteConsistency')
            ->add('conclusion')
            ->add('published')
            ->add('tags', CollectionType::class, array(
                'entry_type'   => TagType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'required' => false
            ))
            ->add('save',      SubmitType::class);
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shiawa\BlogBundle\Entity\AnimeReview'
        ));
    }
}
