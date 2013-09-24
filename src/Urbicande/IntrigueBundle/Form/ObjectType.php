<?php

namespace Urbicande\IntrigueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', null, array(
                'label' => 'Description',
                'attr' => array('class' => 'rte')
            ))
            ->add('creator', null, array('label' => 'Qui s‘en occupe'))
            ->add('place', null, array('label' => 'Un lieu', 'required' => false))
            ->add('appearance', null, array('label' => 'Une condition d‘apparition', 'required' => false))
            ->add('type')
            ->add('owner', null, array('label' => 'Un personnage', 'required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\IntrigueBundle\Entity\Object'
        ));
    }

    public function getName()
    {
        return 'urbicande_intriguebundle_objecttype';
    }
}
