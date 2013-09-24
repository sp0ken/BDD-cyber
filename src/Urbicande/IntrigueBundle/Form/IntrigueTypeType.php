<?php

namespace Urbicande\IntrigueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IntrigueTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Nom'
            ))
            ->add('description', null, array(
                'label' => 'Description',
                'attr' => array('class' => 'rte')
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\IntrigueBundle\Entity\IntrigueType'
        ));
    }

    public function getName()
    {
        return 'urbicande_intriguebundle_intriguetypetype';
    }
}
