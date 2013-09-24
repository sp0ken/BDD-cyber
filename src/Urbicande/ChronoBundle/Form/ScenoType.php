<?php

namespace Urbicande\ChronoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScenoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creator', null, array('label' => 'Référent'))
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', null, array(
                'label' => 'Description',
                'attr' => array('class' => 'rte')
            ))
            ->add('intrigue', null, array('label' => 'Intrigue', 'required' => false))
            ->add('objects', 'entity', array(
                'label' => 'Objets liés',
                'multiple' => true,   // Multiple selection allowed
                'property' => 'name', // Assuming that the entity has a "name" property
                'class'    => 'Urbicande\IntrigueBundle\Entity\Object',
                'required' => false,
            ))
            ->add('parents', 'entity', array(
                'label' => 'Évènements parents',
                'multiple' => true,   // Multiple selection allowed
                'property' => 'name', // Assuming that the entity has a "name" property
                'class'    => 'Urbicande\ChronoBundle\Entity\Sceno',
                'required' => false,
            ))
            ->add('timings', 'collection', array(
                'type' => new TimingType(),
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Timings',
                'options' => array('data_class' => 'Urbicande\ChronoBundle\Entity\Timing')
            ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\ChronoBundle\Entity\Sceno'
        ));
    }

    public function getName()
    {
        return 'urbicande_chronobundle_scenotype';
    }
}
