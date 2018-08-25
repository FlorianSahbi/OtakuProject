<?php

namespace otakuProject\nendoroidBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use otakuProject\nendoroidBundle\Entity\Serie;
use otakuProject\nendoroidBundle\Entity\rangeNumber;
use otakuProject\nendoroidBundle\Entity\Nendoroid;

class NendoroidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',         TextType::class)
            ->add('number',       TextType::class)
            ->add('price',        TextType::class)
            ->add('preview',      TextType::class)
            ->add('serie',        EntityType::class, array('class' => Serie::class,'choice_label' =>'name'))
            ->add('rangeNumber',  EntityType::class, array('class' => rangeNumber::class,'choice_label' =>'rangenumber'))
            ->add('save',         SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'otakuProject\nendoroidBundle\Entity\Nendoroid'));
    }

    public function getBlockPrefix()
    {
        return 'otakuproject_nendoroidbundle_nendoroid';
    }
}