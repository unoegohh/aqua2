<?php
namespace Unoegohh\AdminBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class MenuItemForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $item = $options['data'];
        if(!$item->getChild()->count() ){
            $builder->add('parent', 'entity', array(
                'class' => 'UnoegohhEntitiesBundle:MenuItem',
                'required' => false,
                'query_builder' => function(EntityRepository $er) use ($item) {

                        $qb = $er->createQueryBuilder('u');
                        if($item->getId()){
                            $qb->andWhere($qb->expr()->neq("u.id", $item->getId()));
                        }
                        return $qb
                            ->andWhere($qb->expr()->isNull('u.parent'))
                            ->orderBy('u.name', 'ASC');
                    }));
        }
        $builder
            ->add('name')
            ->add('url')
            ->add('show_to_user')
            ->add('static_page')

            ->add('orderNum', "integer")


        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unoegohh\\EntitiesBundle\\Entity\\MenuItem',
        ));
    }

    public function getName()
    {
        return 'MenuItem';
    }
}