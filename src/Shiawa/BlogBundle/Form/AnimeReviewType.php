<?php

namespace Shiawa\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
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
            ->add('slug')
            ->add('createdAt', 'datetime')
            ->add('updatedAt', 'datetime')
            ->add('animeTitle')
            ->add('image')
            ->add('introduction')
            ->add('studio')
            ->add('licencedAt')
            ->add('synopsis')
            ->add('criticScenario')
            ->add('criticGraphisms')
            ->add('criticSoundtrack')
            ->add('criticConsistency')
            ->add('noteScenario')
            ->add('noteGraphism')
            ->add('noteSoundtrack')
            ->add('noteCharacters')
            ->add('noteConsistency')
            ->add('editor')
            ->add('conclusion')
            ->add('firstEpisode')
            ->add('published')
            ->add('viewed')
            ->add('characters')
            ->add('tags')
            ->add('author')
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
