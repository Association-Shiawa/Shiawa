<?php

namespace Shiawa\FileBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', VichImageType::class, [
                'label' => 'fichier',
                'required' => false,
                'allow_delete' => false,
                'download_label' => '...',
                'download_uri' => true,
                'image_uri' => true,
//                'imagine_pattern' => '...',
            ]);
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
//            'data_class' => 'Shiawa\FileBundle\Entity\File',
            'csrf_protection' => false
        ));
    }
}
