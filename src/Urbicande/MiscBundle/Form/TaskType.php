<?php

namespace Urbicande\MiscBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', null, array('label' => 'Tache'))
            ->add('writer', null, array('label' => 'Asigner à'))
            ->add('endDate', 'date', array(
                'label' => 'Date de fin',
                'required' => false,
                'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'widget' => 'choice'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\MiscBundle\Entity\Task'
        ));
    }

    public function getName()
    {
        return 'urbicande_miscbundle_tasktype';
    }
}
