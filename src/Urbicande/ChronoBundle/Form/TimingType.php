<?php

namespace Urbicande\ChronoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TimingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start_day', null, array(
                'label' => 'Jour de début',
                'attr' => array('min' => 1)
            ))
            ->add('start_hour', null, array('label' => 'Heure de début'))
            ->add('end_day', null, array(
                'label' => 'Jour de fin',
                'attr' => array('min' => 1)
            ))
            ->add('end_hour', null, array('label' => 'Heure de fin (ne pas utiliser 00:00 pile)'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\ChronoBundle\Entity\Timing'
        ));
    }

    public function getName()
    {
        return 'urbicande_chronobundle_timingtype';
    }
}
