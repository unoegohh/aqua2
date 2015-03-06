<?php
namespace Unoegohh\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class ItemForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', "textarea")
            ->add('active', null, array("required" => false))
            ->add('top', null, array("required" => false))
            ->add('price', null, array("required" => false))
            ->add('priceEUR', null, array("required" => false))
            ->add('priceUSD', null, array("required" => false))
            ->add('category_id', null, array("required" => true))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unoegohh\\EntitiesBundle\\Entity\\Item',
        ));
    }

    public function getName()
    {
        return 'Item';
    }
}