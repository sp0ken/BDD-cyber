<?php

namespace Urbicande\MiscBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MusiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', null, array('label' => 'Numéro'))
            ->add('name', null, array('label' => 'Titre'))
            ->add('link', 'url', array(
                'label' => 'Lien',
                'required' => false
            ))
            ->add('type', 'choice', array(
                'label' => 'Type',
                'choices'   => array('Ambiance' => 'Ambiance', 'TDE' => 'TDE'),
                'required'  => true,
            ))
            ->add('description', null, array(
                'label' => 'Description',
                'attr' => array('class' => 'rte')
            ))
            ->add('tde', null, array(
                'label' => 'TDE',
                'attr' => array('class' => 'rte')
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\MiscBundle\Entity\Musique'
        ));
    }

    public function getName()
    {
        return 'urbicande_miscbundle_musiquetype';
    }
}
