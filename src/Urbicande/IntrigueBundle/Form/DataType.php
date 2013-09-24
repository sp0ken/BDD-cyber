<?php

namespace Urbicande\IntrigueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', null, array(
                'label' => 'Numéro de l‘information',
                'attr' => array('min' => 1)
            ))

            ->add('information', null, array(
                'label' => 'Information', 
                'required' => false,
                'attr' => array('placeholder' => 'Tous les détails factuels doivent être présents, mais le style d’écriture doit être épuré, sobre.', 'class' => 'rte')
            ))
            ->add('knowers', 'entity', array(
                'label' => 'Qui la connait',
                'multiple' => true,   // Multiple selection allowed
                'class'    => 'Urbicande\PersoBundle\Entity\Personnage',
                'required' => false,
            ))
            ->add('documents', 'entity', array(
                'label' => 'Documents liés',
                'multiple' => true,   // Multiple selection allowed
                'property' => 'name',
                'class'    => 'Urbicande\IntrigueBundle\Entity\Object',
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\IntrigueBundle\Entity\Data'
        ));
    }

    public function getName()
    {
        return 'urbicande_intriguebundle_datatype';
    }
}
