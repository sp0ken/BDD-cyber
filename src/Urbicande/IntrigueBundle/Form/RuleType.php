<?php

namespace Urbicande\IntrigueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', null, array(
                'label' => 'Numéro',
                'attr' => array('min' => 1)
            ))
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', null, array(
                'label' => 'Description',
                'attr' => array('class' => 'rte')
            ))
            ->add('writer', null, array('label' => 'Assigner à'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\IntrigueBundle\Entity\Rule'
        ));
    }

    public function getName()
    {
        return 'urbicande_intriguebundle_ruletype';
    }
}
