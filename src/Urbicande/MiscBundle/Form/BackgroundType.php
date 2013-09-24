<?php

namespace Urbicande\MiscBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BackgroundType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'Titre'))
            ->add('body', null, array(
                'label' => 'Texte',
                'attr' => array('class' => 'rte')
            ))
            ->add('writer', null, array('label' => 'Assigner à'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\MiscBundle\Entity\Background'
        ));
    }

    public function getName()
    {
        return 'urbicande_miscbundle_backgroundtype';
    }
}
