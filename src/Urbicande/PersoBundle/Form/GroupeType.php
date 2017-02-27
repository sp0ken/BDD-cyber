<?php

namespace Urbicande\PersoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', null, array(
                'label' => 'Description',
                'required' => false,
                'attr' => array('placeholder' => 'La description du groupe', 'class' => 'rte')
            ))
            ->add('particularity', null, array(
                'label' => 'Particularités', 
                'required' => false,
                'attr' => array('placeholder' => 'Les particularités du groupe, signe de reconnaissance, rites d\'accession par exemple', 'class' => 'rte')
            ))
            ->add('writer', null, array('label' => 'Scénariste référent'))
            ->add('members', 'entity', array(
                'label' => 'Ajouter des personnages',
                'multiple' => true,   // Multiple selection allowed
                'class'    => 'Urbicande\PersoBundle\Entity\Personnage',
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\PersoBundle\Entity\Groupe'
        ));
    }

    public function getName()
    {
        return 'urbicande_persobundle_groupetype';
    }
}
