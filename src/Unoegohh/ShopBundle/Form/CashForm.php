<?php
namespace Unoegohh\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class CashForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fio')
            ->add('descr',"textarea")
            ->add('order', "hidden")
            ->add('totalPrice', "hidden")
            ->add('phone')
            ->add('email', 'email')
            ->add('address')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unoegohh\\EntitiesBundle\\Entity\\Order',
        ));
    }

    public function getName()
    {
        return 'CashOrder';
    }
}