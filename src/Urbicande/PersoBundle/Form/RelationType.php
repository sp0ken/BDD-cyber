<?php

namespace Urbicande\PersoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('detail', null, array(
                'label' => 'Détail',
                'required' => false,
                'attr' => array('placeholder' => 'Les détails de cette relation particulière', 'class' => 'rte')
            ))
            ->add('knower')
            ->add('knowee')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\PersoBundle\Entity\Relation'
        ));
    }

    public function getName()
    {
        return 'urbicande_persobundle_relationtype';
    }
}
