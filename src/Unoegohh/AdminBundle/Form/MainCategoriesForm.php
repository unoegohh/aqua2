<?php
namespace Unoegohh\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class MainCategoriesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = array(
            'veget' => 'Броколи',
            'meat' => 'Мясо',
            'beverages' => 'Напитки',
            'bakery' => 'Хлевушек',
            'sweets' => 'Мороженно',
            'hygiene' => 'Спрей',
            'electronics' => 'Микроволновка',
            'toys' => 'Игрушки',
        );

        $builder
            ->add('top_left')
            ->add('left_top')
            ->add('left_bottom')
            ->add('bottom_left')
            ->add('top_right')
            ->add('right_top')
            ->add('right_bottom')
            ->add('bottom_right')
            ->add('top_left_pic', 'choice', array(
                'choices'   => $choices,
                'required'  => false,
            ))
            ->add('left_top_pic', 'choice', array(
                'choices'   => $choices,
                'required'  => false,
            ))
            ->add('left_bottom_pic', 'choice', array(
                'choices'   => $choices,
                'required'  => false,
            ))
            ->add('bottom_left_pic', 'choice', array(
                'choices'   => $choices,
                'required'  => false,
            ))
            ->add('right_top_pic', 'choice', array(
                'choices'   => $choices,
                'required'  => false,
            ))
            ->add('right_bottom_pic', 'choice', array(
                'choices'   => $choices,
                'required'  => false,
            ))
            ->add('bottom_right_pic', 'choice', array(
                'choices'   => $choices,
                'required'  => false,
            ))
            ->add('top_right_pic', 'choice', array(
                'choices'   => $choices,
                'required'  => false,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unoegohh\\EntitiesBundle\\Entity\\MainCategories',
        ));
    }

    public function getName()
    {
        return 'MainCategories';
    }
}