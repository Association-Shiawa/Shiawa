<?php
// src/Shiawa/BlogBundle/Form/Type/DatalistType
namespace Shiawa\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DataListType extends AbstractType
{
    public function getParent()
    {
        return  TextType::class;
    }



    public function getName()
    {
        return 'datalist';
    }
}