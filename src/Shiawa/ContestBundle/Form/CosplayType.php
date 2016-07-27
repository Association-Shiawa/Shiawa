<?php

namespace Shiawa\ContestBundle\Form;

use Shiawa\UserBundle\Form\PersonalInfoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CosplayType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cosplayer', PersonalInfoType::class)
            ->add('characterName', TextType::class)
            ->add('serieName', TextType::class)
            ->add('serieType', ChoiceType::class, array(
                'choices'  => array(
                    'Jeux-vidéos' => 'Jeux-vidéo',
                    'Anime & Manga' => 'Anime et manga',
                    'Série TV' => 'Série TV',
                    'Film' => 'Film',
                    'Autre' => 'Autre'
                )))
            ->add('image', TextType::class)
            ->add('createdParts', TextareaType::class)
            ->add('costumisedParts', TextareaType::class)
            ->add('boughtParts', TextareaType::class)
            ->add('save', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shiawa\ContestBundle\Entity\Cosplay'
        ));
    }
}
