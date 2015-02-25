<?php
namespace Unoegohh\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class StaticPageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('active', null, array('required' => false))
            ->add('url', null, array('required' => false))
            ->add('show_to_user', null, array('required' => false))
            ->add('text', 'textarea', array('required' => true))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unoegohh\\EntitiesBundle\\Entity\\StaticPage',
        ));
    }

    public function getName()
    {
        return 'StaticPage';
    }
}