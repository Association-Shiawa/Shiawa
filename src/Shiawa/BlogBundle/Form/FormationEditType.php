<?php

namespace Shiawa\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class FormationEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('chapters', CollectionType::class, array(
            'entry_type'   => ChapterType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'required' => false,
            'by_reference' => false
        ));
    }

    public function getParent()
    {
        return FormationType::class;
    }
}
