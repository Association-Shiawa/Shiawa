<?php

namespace Shiawa\BlogBundle\Form;

use Shiawa\BlogBundle\Form\Type\DataListType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            /*->add('anime', DataListType::class, array(
                'attr' => array(
                    'placeholder' => "Choisissez un anime",
                    'class' => 'autocomplete',
                    'list' => 'animes'
                ),
                'mapped' => false
            ))*/
            ->add('image')
            ->add('introduction')
            ->add('criticScenario', null, array(
                'required' => false
            ))
            ->add('criticGraphisms', null, array(
                'required' => false
            ))
            ->add('criticSoundtrack', null, array(
                'required' => false
            ))
            ->add('criticConsistency', null, array(
                'required' => false
            ))
            ->add('noteScenario', RangeType::class, array(
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('noteGraphism', RangeType::class, array(
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('noteSoundtrack', RangeType::class, array(
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('noteCharacters', RangeType::class, array(
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('noteConsistency', RangeType::class, array(
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
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
